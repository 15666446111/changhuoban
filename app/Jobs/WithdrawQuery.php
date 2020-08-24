<?php

namespace App\Jobs;

use App\Withdraw;
use Illuminate\Bus\Queueable;
use App\Services\Cj\RepayCjController;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WithdrawQuery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$withdraw 要查询的提现订单]
     * @var [ ORM ]
     */
    protected $withdraw;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 1;


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
    public function __construct(Withdraw $withdraw)
    {
        $this->withdraw = $withdraw;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ###
        ###   如果订单状态不在受理中 不进行操作
        ###
        if($this->withdraw->state != "4") return false;

        ###
        ###  执行代付查询
        ###
        $applition  = new RepayCjController($this->withdraw);

        $result     = $applition->payQuery();

        $this->withdraw->api_return_data = json_encode($result);

        if($result->data && $result->data->remitStatus){
            # 还是已受理的状态 重新压入
            if($result->data->remitStatus == "1"){
                $this->dispatch($this->withdraw)->onQueue('withdraw')->delay(now()->addMinutes(10));
                $this->withdraw->remark = $result->data->message;
                $this->withdraw->save();
                return true; 
            # 转账成功
            }elseif($result->data->remitStatus == "2"){
                $this->withdraw->state  = 2;
                $this->withdraw->make_state = 1;
                $this->withdraw->remark = $result->data->message;
                $this->withdraw->save();
            # 转账失败
            }elseif($result->data->remitStatus == "3"){
                $this->withdraw->state  = 3;
                $this->withdraw->make_state = 2;
                $this->withdraw->remark = $result->data->message;
                $this->withdraw->save();
                // 增加用户钱包余额
                if ($this->withdraw->type == 1) {
                    \App\UserWallet::where('user_id', $this->withdraw->user_id)->increment('cash_blance', $this->withdraw->money);
                }
                if ($this->withdraw->type == 2) {
                    \App\UserWallet::where('user_id', $this->withdraw->user_id)->increment('return_blance', $this->withdraw->money);
                }
            }

        }else{
            $this->dispatch($this->withdraw)->onQueue('withdraw')->delay(now()->addMinutes(10));
            $this->withdraw->remark = "查询错误!";
            $this->withdraw->save();
            return false;
        }
    }
}
