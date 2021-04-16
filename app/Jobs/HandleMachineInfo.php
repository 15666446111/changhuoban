<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\RegNoticeContent;
use App\Http\Controllers\MachineConfig;
use App\Services\Pmpos\PmposController;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleMachineInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 接口推送的商户信息
     * @var [type]
     */
    protected $regContent;


    /**
     * 机具信息
     * @var [type]
     */
    protected $machine;


    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 180;


    /**
     * 如果模型缺失即删除任务。
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RegNoticeContent $regContent)
    {
        
        $this->regContent = $regContent;

        $this->machine = \App\Machine::where('sn', $this->regContent->termSn)->first();

    }

     /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        /**
         * 检查机器sn是否入库
         * @var [type]
         */
        if (empty($this->machine) || !$this->machine) {

            $this->regContent->remark = '该机器还未入库';
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;

        } else {

            // 更新机器开通状态
            $this->machine->open_state  = 1;
            $this->machine->open_time   = date('Y-m-d H:i:s', time());

            // 机器过期状态
            if (!empty($this->machine->active_end_time) && Carbon::now() > $this->machine->active_end_time) {
                $this->machine->overdue_state = 1;
            }
            $this->machine->save();
            
        }

        /**
         * 检查机器sn是否发货
         * @var [type]
         */
        if (empty($this->machine->user_id)) {
            $this->regContent->remark = '该机器还未发货';
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘信息是否存在
         * @var [type]
         */
        if (empty($this->machine->operate)) {
            $this->regContent->remark = '未查询到机器归属操盘信息';
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属活动信息是否存在
         * @var [type]
         */
        if (!$this->machine->policys || empty($this->machine->policys)) {
            $this->regContent->remark = '该机器活动信息不存在';
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘方和畅捷后台是否一致
         * @var [type]
         */
        $systemMerchant = \App\AdminSetting::where('operate_number', $this->machine->operate)->value('system_merchant');
        if ($systemMerchant != $this->regContent->config_agent_id) {
            $this->regContent->remark = '该机器归属操盘信息有误';
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器是否在畅捷一级后台
         * @var [type]
         */
        // if ($this->regContent->config_agent_id != $this->regContent->agentId) {
        //     $this->regContent->remark = '该机器不在您的畅捷一级后台';
        //     $this->regContent->state = '2';
        //     $this->regContent->save();
        //     return false;
        // }

        /**
         * 添加和更新商户绑定信息
         * @var [type]
         */
        try {

            $merchant = \App\Merchant::where('code', $this->regContent->merchantId)->first();

            if (!$merchant || empty($merchant)) {
                
                ## 商户不存在时，添加商户信息
                $merchant = \App\Merchant::create([
                    'user_id'       => $this->machine->user_id,
                    'code'          => $this->regContent->merchantId,
                    'operate'       => $this->machine->operate,
                    'open_time'     => Carbon::now()
                ]);

            }
             // 当前机器未绑定商户时，更新绑定状态
            if ($this->machine->bind_status == 0 || empty($this->machine->merchant_id)) {

                \App\Machine::where('sn', $this->regContent->termSn)->update([
                    'merchant_id'       => $merchant->id,
                    'bind_status'       => 1,
                    'bind_time'         => date('Y-m-d H:i:s', time())
                ]);
            } else {
                // 判断当前机器绑定商户和推送信息是否一致，信息不一致时，更新商户信息
                if ($this->machine->merchants->code != $this->regContent->merchantId) {

                    // 更新商户信息
                    \App\Machine::where('sn', $this->regContent->termSn)->update([
                        'merchant_id'       => $merchant->id
                    ]);

                    // 更新绑定记录的解绑状态
                    \App\MerchantsBindLog::where('sn', $this->regContent->termSn)
                                        ->where('bind_state', 1)
                                        ->update(['bind_state' => 0]);
                }
            }

            $bingLogInfo = \App\MerchantsBindLog::where('merchant_code', $this->regContent->merchantId)
                                                ->where('sn', $this->regContent->termSn)
                                                ->first();
            // 没有绑定记录，或者当前机器和商户已解绑时，添加新的绑定记录
            if (empty($bingLogInfo) || $bingLogInfo->bind_state == 0) {
                \App\MerchantsBindLog::create([
                    'merchant_code'     => $this->regContent->merchantId,
                    'sn'                => $this->regContent->termSn
                ]);
            }

        } catch (\Exception $e) {
            $this->regContent->remark .= '商户绑定:' . json_encode($e->getMessage());
            $this->regContent->save();
            return false;
        }

        /**
         * 按冻结状态激活的机器,发起冻结
         */
        try {

            if ($this->machine->policys->active_type != 1) {
                $this->regContent->remark = '该机器非冻结机器';
                $this->regContent->save();
            } else {

                // 检查是否设置冻结金额
                if ($this->machine->policys->active_price == 0) {
                    $this->regContent->remark = '该机器未设置冻结金额';
                    $this->regContent->state = '2';
                    $this->regContent->save();
                    return false;
                }

                // 短信模板编号
                $simCharge = \App\AdminShort::where('id', $this->machine->policys->short_id)->value('number');

                // 发起冻结
                $pmpos = new PmposController($this->regContent->merchantId, $this->regContent->termSn);

                $data = $pmpos->feeFrozen($simCharge, $this->machine->policys->active_price, 0);

                $returnData = json_decode($data['return_data']);

                // 添加冻结记录
                \App\MerchantsFrozenLog::create([
                    'merchant_code'     => $this->regContent->merchantId,
                    'sn'                => $this->regContent->termSn,
                    'type'              => 1,
                    'frozen_money'      => $this->machine->policys->active_price,
                    'state'             => $returnData->code == '00' ? 1 : 0,
                    'return_data'       => $data['return_data'],
                    'send_data'         => $data['send_data']
                ]);

                $this->regContent->remark .= '服务费冻结:' . json_encode($returnData, JSON_UNESCAPED_UNICODE);
                $this->regContent->state = $returnData->code == '00' ? 1 : 2;
                $this->regContent->save();
            }

        } catch (\Exception $e) {

            $this->regContent->remark .= '服务费冻结Catch:' . json_encode($e->getMessage());
            $this->regContent->state = '2';
            $this->regContent->save();
            return false;

        }

        /**
         * 流量卡费冻结
         */
        try {

            // 检查是否设置流量卡冻结
            if ($this->machine->policys->sim_charge <= 0) {
                return false;
            }
            
            // 创建流量卡冻结记录
            $forzenLog = \App\MerchantsFrozenLog::create([
                'merchant_code'     => $this->regContent->merchantId,
                'sn'                => $this->regContent->termSn,
                'type'              => 2,
                'frozen_money'      => $this->machine->policys->sim_charge,
                'state'             => 0,
                'sim_agent_time'    => Carbon::now()->addMonth($this->machine->policys->sim_delay)->toDateTimeString(),
                'send_data'         => '',
                'return_data'       => ''
            ]);

            // 未设置延迟扣款时间时，发起扣款
            if ($this->machine->policys->sim_delay == 0) {
                \App\Jobs\SimFrozen::dispatch($forzenLog)->onQueue('SimFrozen');
            }

        } catch (Exception $e) {
            
            $this->regContent->remark .= '流量卡费冻结Catch:' . json_encode($e->getMessage());
            $this->regContent->save();
            return false;

        }
    }
}
