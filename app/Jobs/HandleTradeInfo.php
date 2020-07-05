<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleTradeInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$podcast 用来接收参数的变量]
     * @var [type]
     */
    protected $trade;

    protected $merchants;

    protected $agentId;

    protected $configAgentId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 120;

    public function __construct($params = '',$merchant = '',$agId = '',$configId = '',$number = '')
    {
        $this->trade = $params;

        $this->merchants = $merchant;

        $this->agentId = $agId;

        $this->configAgentId = $configId;

        $this->short_id = $number;

    }

    

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        /**
         * @version [<vector>] [< 检查该机器是否入库>]
         */
        if (empty($this->trade->merchants_sn)) {
            $this->trade->remark = '仓库中无此终端号!';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查该机器是否发货>]
         */
        if (!$this->trade->merchants_sn->user_id || $this->trade->merchants_sn->user_id == "null") {
            $this->trade->remark = '该机器还未发货!';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查该机器所属操盘方和畅捷后台是否一致>]
         */
        if ($this->trade->merchants_sn->operate != $this->trade->agt_merchant_id) {
            $this->trade->remark = '该机器归属操盘方信息有误';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查是否是重复推送的数据 >]
         * transDate: 接口推送的交易日期
         * rrn: 参考号
         */
        $sameTrade = \App\Trade::where('transDate', $this->trade->transDate)->where('rrn', $this->trade->rrn)
                                ->first();
        if (empty($sameTrade)) {
            $this->trade->remark = '该交易为重复推送数据';
            $this->trade->save();
            return false;
        }



        /**
         * @version [<vector>] [< 实行商户绑定>]
         */
        if ($this->trade->merchants_sn->bind_status == "0" || $this->trade->merchants_sn->merchant_id == null) {
            
        }

        /**
         * @version [< 给当前交易进行分润发放 >]
         */
        
        try {


        } catch (\Exception $e) {
            // $this->trade->remark = $this->trade->remark."<br/>分润:".json_encode($e->getMessage());
            // $this->trade->save();
        }

        /**
         * 服务费代收
         */
        try { 

            $token = $this->getToken('2083');
            $url = 'https://pmpos.chanpay.com/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/amountFrozen';
            $traceNo = $this->msectime();
            
            $postData = [
                'agentId' => $this->agentId,      // 渠道编号
                'token' => $token['data']['token'],     // 令牌
                'traceNo' => $traceNo,        // 请求流水号
                'merchId' => $this->$merchants->code,      // 商户号
                'directAgentId' => $this->directAgentId,   // 商户直属代理商编号
                'sn' => $this->$merchants->machines->sn,        // 终端SN序列号
                'posCharge' => \App\Machine::where('sn',$this->$merchants->machines->sn)->first()->policys->active_price,       // POS服务费金额(元)
                'vipCharge' => '0',         // VIP会员服务费金额(元)
                'simCharge' => '0',       // SIM服务费金额(元)
                'smsSend' => '1',         // 是否发送短信(1发送 0不发送)
                'smsCode' => $this->short_id,        // 短信模板编号
            ];
            $data = $this->send($url, $postData);
            return $data;

        } catch (\Exception $e) {
            
            $e->getMessage();

        }
    }
}
