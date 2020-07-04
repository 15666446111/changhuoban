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
    public function __construct(Machine $merchants)
    {
        
        $this->merchants = $merchants;

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
