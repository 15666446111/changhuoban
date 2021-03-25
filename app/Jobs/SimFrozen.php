<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\MerchantsFrozenLog;
use App\Services\Pmpos\PmposController;

class SimFrozen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$frozenLog 冻结订单]
     * @var [type]
     */
    protected $frozenLog;


    /**
     * [$machine 机具信息]
     * @var [type]
     */
    protected $machine;


    /**
     * [$policy 政策信息]
     * @var [type]
     */
    protected $policy;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MerchantsFrozenLog $frozenLog)
    {
        $this->frozenLog = \App\MerchantsFrozenLog::whereId($frozenLog->id)->first();

        // 初始化机具信息
        $this->machine = \App\Machine::where('sn', $frozenLog->sn)->first();

        // 初始化活动信息
        $this->policy = $this->machine->policys;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 检查订单是否是待冻结状态
        if ($this->frozenLog->state !== 0) {
            $this->frozenLog->remark .= '&订单非待冻结状态:' . $this->frozenLog->state;
            $this->frozenLog->save();
            return false;
        }

        // 检查机具政策信息
        if (!$this->policy || empty($this->policy)) {
            $this->frozenLog->remark = '未获取到机具政策信息';
            $this->frozenLog->save();
            return false;
        }

        // 检查是否到需冻结日期
        if ($this->frozenLog->sim_agent_time > Carbon::now()->toDateTimeString()) {
            $this->frozenLog->remark = '未到需发起日期';
            $this->frozenLog->save();
            return false;
        }

        // 检查待冻结订单里记录的商户号与机器当前绑定商户是否一致。不一致时，更新订单为已取消状态
        if ($this->frozenLog->merchant_code != $this->machine->merchants->code) {
            $this->frozenLog->remark    = '当前机器与商户已解绑';
            $this->frozenLog->state     = -1;
            $this->frozenLog->save();
            return false;
        }

        // 检查短信模板是否配置
        $smsCode = \App\AdminShort::where('id', $this->policy->sim_short_id)->value('number');
        if (empty($smsCode)) {
            $this->frozenLog->remark = '未配置短信模板';
            $this->frozenLog->save();
            return false;
        }

        /**
         * 发起冻结
         */
        try {
            
            // 实例化3.0接口类
            $pmposModel = new PmposController($this->frozenLog->merchant_code, $this->frozenLog->sn);
            
            // 发起冻结
            $data = $pmposModel->feeFrozen($smsCode, 0, $this->policy->sim_charge);

            $returnData = json_decode($data['return_data']);

            // 请求接口数据和接口返回数据
            $this->frozenLog->return_data   = $data['return_data'];
            $this->frozenLog->send_data     = $data['send_data'];

            // 发起冻结失败时，更新冻结订单状态并返回
            if ($returnData->code != '00') {
                $this->frozenLog->remark    = $returnData->message;
                $this->frozenLog->state     = 2;
                $this->frozenLog->save();
                return false;
            }

            $this->frozenLog->remark        = '发起成功';
            $this->frozenLog->state         = 1;
            $this->frozenLog->save();

            // 创建一条新的待发起冻结订单
            \App\MerchantsFrozenLog::create([
                'merchant_code'     => $this->machine->merchants->code,
                'sn'                => $this->frozenLog->sn,
                'type'              => 2,
                'frozen_money'      => $this->machine->policys->sim_charge,
                'state'             => 0,
                'sim_agent_time'    => Carbon::now()->addMonth($this->machine->policys->sim_cycle)->toDateTimeString(),
                'send_data'         => '',
                'return_data'       => '',
            ]);

            // 更新流量卡费已冻结次数
            $this->machine->sim_frozen_num += 1;
            $this->machine->save();

        } catch (Exception $e) {
            $this->frozenLog->remark .= 'SIM服务费冻结:' . json_encode($e->getMessage());
            $this->frozenLog->save();
        }
    }
}
