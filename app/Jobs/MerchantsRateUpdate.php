<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Encore\Admin\Facades\Admin;
use App\Services\Pmpos\PmposController;

class MerchantsRateUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$rateType 修改的费率类型]
     * @var [type]
     */
    protected $rateType;


    /**
     * [$rate 需要增加/减少的值]
     * @var [type]
     */
    protected $rate;


    /**
     * [$merchants 机具信息]
     * @var [type]
     */
    protected $machine;


    /**
     * [$merchants 商户信息]
     * @var [type]
     */
    protected $merchants;


    /**
     * [$merchants 后台登录用户id]
     * @var [type]
     */
    protected $adminId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($machine, $rateType, $rate)
    {
        // 初始化机具信息
        $this->machine = $machine;

        // 初始化商户信息
        $this->merchants = $machine->merchants;

        $this->adminId = Admin::user()->id;

        $this->rateType = $rateType;

        $this->rate = $rate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->rateType)) {
            $this->addMerchantsRateLog('01', '费率类型查询失败');
            return 'false';
        }

        // 查询商户费率
        $pmpos = new PmposController($this->merchants->code, '');
        $rateData = json_decode($pmpos->getMerchantFee(), true);

        // 费率查询失败时
        if ($rateData['code'] !== '00') {
            $this->addMerchantsRateLog($rateData['code'], $rateData['message']);
            return 'false';
        }

        // 增加值的单位转换为元和 _%
        $divisor = ($this->rateType == 'dFeeMax' || $this->rateType == 'd0SingleCashDrawal') ? 100000 : 1000;

        // 修改费率
        $data[$this->rateType] = bcdiv($this->rate, $divisor, 3);
        $reData = json_decode( $pmpos->updateNonAudit($data) );

        if ($reData->code == '00') {

            // 查询修改后的商户费率
            $newRateData    = json_decode( $pmpos->getMerchantFee() );

            // 修改前商户费率信息
            $originalRate   = json_encode($rateData['data']);
            // 修改后商户费率信息
            $adjustRate     = $newRateData->code == '00' ? json_encode($newRateData->data) : '';

            // 添加商户费率修改记录
            $this->addMerchantsRateLog($reData->code, '修改成功', $originalRate, $adjustRate);

        } else {

            $this->addMerchantsRateLog($reData->code, $reData->message);
        }
    }

    /**
     * [addMerchantsRateLog 添加商户费率修改记录]
     * @param [type] $state         [修改状态]
     * @param [type] $remark        [描述]
     * @param string $original_rate [修改前费率信息]
     * @param string $adjust_rate   [修改后费率信息]
     */
    public function addMerchantsRateLog($code, $remark, $original_rate='', $adjust_rate='')
    {
        $state = $code == '00' ? 1 : 0;
        \App\MerchantsRateLog::create([
            'merchant_code'     => $this->merchants->code,
            'policy_group_id'   => $this->machine->policys->policy_group_id,
            'original_rate'     => $original_rate,
            'adjust_rate'       => $adjust_rate,
            'adjust_user_id'    => $this->adminId,
            'remark'            => $remark,
            'state'             => $state,
            'operate'           => $this->machine->operate
        ]);
    }
}
