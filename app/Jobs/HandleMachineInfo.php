<?php

namespace App\Jobs;

use App\Http\Controllers\MachineConfig;
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
    public $timeout = 120;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Machine $regContent)
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

        // $pmpos = \App\Services\Pmpos\PmposController();

        

        /**
         * 检查机器sn是否入库
         * @var [type]
         */
        if ( empty($this->machine) || !$this->machine) {
            $this->regContent->remark = '该机器还未入库';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器sn是否发货
         * @var [type]
         */
        if (empty($this->machine->user_id)) {
            $this->regContent->remark = '该机器还未发货';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘信息是否存在
         * @var [type]
         */
        if (empty($this->machine->operate)) {
            $this->regContent->remark = '未查询到机器归属操盘信息';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘方和畅捷后台是否一致
         * @var [type]
         */
        $systemMerchant = \App\AdminSetting::where('operate', $this->machine->operate)->value('system_merchant');
        if ($systemMerchant != $this->regContent->config_agent_id) {
            $this->regContent->remark = '该机器归属操盘信息有误';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器是否在畅捷一级后台
         * @var [type]
         */
        if ($this->regContent->config_agent_id != $this->regContent->agentId) {
            $this->regContent->remark = '该机器不在您的畅捷一级后台';
            $this->regContent->save();
            return false;
        }

        /**
         * 更新商户和机具绑定状态
         * @var [type]
         */
        $merchant = \App\Merchant::where('code', $this->regContent->merchantId)->first();
        if (!$merchant || empty($merchant)) {
            
            ## 商户不存在时，添加商户信息
            $merchant = \App\Merchant::create([
                'user_id'       => $this->machine->user_id,
                'code'          => $this->regContent->merchantId,
                'operate'       => $this->machine->operate
            ]);

            ## 当前机器未绑定商户时，更新绑定状态
            if ($this->machine->bind_state == 0 || empty($this->machine->merchant_id)) {

                \App\Machine::where('sn', $this->regContent->termSn)->update([
                    'bind_state'        => 1,
                    'merchant_id'       => $merchant->id
                ]);
            } else {
                // 判断当前机器绑定商户和推送信息是否一致，信息不一致时，更新商户信息
                if ($this->machine->merchants->code != $this->regContent->merchantId) {

                    \App\Machine::where('sn', $this->regContent->termSn)->update([
                        'merchant_id'       => $merchant->id
                    ]);

                    // 更新绑定记录的解绑状态
                    \App\MerchantBindLog::where('merchant_code', $this->regContent->merchantId)
                                        ->where('sn', $this->regContent->termSn)
                                        ->update(['bind_state' => 0]);
                }
            }

        } else {

        }

        // 添加绑定记录
        \App\MerchantBindLog::create([
            'merchant_code'     => $this->regContent->merchantId,
            'sn'                => $this->regContent->termSn
        ]);










        
         /**
         * 服务费代收
         */
        try {

            $config = new MachineConfig();

            $token = $config->getToken('2083');
            $url = 'https://pmpos.chanpay.com/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/amountFrozen';
            $traceNo = $config->msectime();
            
            $postData = [
                'agentId' => $this->$merchants->agentId,      // 渠道编号
                'token' => $token['data']['token'],     // 令牌
                'traceNo' => $traceNo,        // 请求流水号
                'merchId' => $this->$merchants->merchantId,      // 商户号
                'directAgentId' => $this->$merchants->directAgentId,   // 商户直属代理商编号
                'sn' => $this->$merchants->machines->sn,        // 终端SN序列号
                'posCharge' => \App\Machine::where('sn',$this->$merchants->machines->sn)->first()->policys->active_price / 100,       // POS服务费金额(元)
                'vipCharge' => '0',         // VIP会员服务费金额(元)
                'simCharge' => '0',       // SIM服务费金额(元)
                'smsSend' => '1',         // 是否发送短信(1发送 0不发送)
                'smsCode' => \App\AdminShort::where('operate',$this->$merchants->machines->operate)->first()->id,        // 短信模板编号
            ];
            
            $key = \App\AdminSetting::where('operate',$this->$merchants->machines->operate)->first()->system_secret;
            
            $data = $config->send($url, $postData,$key);

            if($data['code'] && $data['code'] == 00){
                //记录服务费代收数据
                \App\ServiceCharge::create([

                    'agentId' => $this->$merchants->agentId,      // 渠道编号
                    'token' => $token['data']['token'],     // 令牌
                    'traceNo' => $traceNo,        // 请求流水号
                    'merchId' => $this->$merchants->merchantId,      // 商户号
                    'directAgentId' => $this->$merchants->directAgentId,   // 商户直属代理商编号
                    'sn' => $this->$merchants->machines->sn,        // 终端SN序列号
                    'posCharge' => \App\Machine::where('sn',$this->$merchants->machines->sn)->first()->policys->active_price / 100,       // POS服务费金额(元)
                    'vipCharge' => '0',         // VIP会员服务费金额(元)
                    'simCharge' => '0',       // SIM服务费金额(元)
                    'smsSend' => '1',         // 是否发送短信(1发送 0不发送)
                    'smsCode' => \App\AdminShort::where('operate',$this->$merchants->machines->operate)->first()->id,        // 短信模板编号

                ]);

            }

            return $data;

        } catch (\Exception $e) {
            
            $e->getMessage();

        }
        
    }
}
