<?php

namespace App\Jobs;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutoPromotion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$user 要检查的用户model]
     * @var orm 
     */
    protected $user;


    /**
     * [$start 交易开始时间]
     * @var [datetime]
     */
    protected $start;


    /**
     * [$end 交易结束时间]
     * @var [datetime]
     */
    protected $end;


    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 180;


    /**
     * [$group 用户初始用户组]
     * @var integer
     */
    protected $group = 1;


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
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->start = Carbon::now()->subMonth(1)->firstOfMonth()->toDateTimeString();

        $this->end   = Carbon::now()->firstOfMonth()->toDateTimeString();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{

            $logs = new \App\AutoPromotionLog;

            $logs->user_id = $this->user->id;

            // 获取该用户的操盘方信息 以及晋升标准
            $AdminSetting = \App\AdminSetting::where('operate_number', $this->user->operate)->first();
            if(!$AdminSetting or empty($AdminSetting)){
                // 此处为找不到操盘方信息
                $logs->status = 0;
                $logs->biz    = '找不到该用户的操盘方信息!';
                $logs->save();
                return false;
            }

            $logs->operate = $this->user->operate;

            if($AdminSetting->type != '1' ){
                // 此处为 所属机构不是操盘方的情况下
                $logs->status = 0;
                $logs->biz    = '所属机构非操盘方!';
                $logs->save();
                return false;
            }

            if($AdminSetting->pattern != '1'){
                // 此处为操盘模式不为联盟模式的情况下
                $logs->status = 0;
                $logs->biz    = '操盘方不是联盟模式!';
                $logs->save();
                return false;
            }

            if(!$this->user->is_verfity){
                // 此处为是该会员否参与晋升
                $logs->biz    = '该用户不审核自动晋升标准!';
                $logs->save();
                return false;
            }

            // 获取操盘下 自动晋升标准
            $Auto = \App\AutoPromotion::where('operate', $AdminSetting->operate_number)->where('trade_count', '>', 0)->orderBy('trade_count', 'asc')->get();

            if($Auto->isEmpty()){
                // 此处为 操盘方未设置 或没有自动晋升标准的时候
                $logs->status = 0;
                $logs->biz    = '操盘方自动晋升标准未设置或未找到!';
                $logs->save();
                return false;
            }

            $logs->remark = json_encode($Auto->toArray());

            // 获取该用户及其团队的所有非借记卡交易
            $team   = \App\UserRelation::where('parents', 'like', '%\_'.$this->user->id.'\_%')->pluck('user_id')->toArray();
            $team[] = $this->user->id;
            $tradeCount = \App\Trade::whereBetween('trade_time', [$this->start,  $this->end])->whereIn('user_id', $team)
                    ->where('card_type', '!=', '0')
                    ->where('is_repeat', 0)
                    ->where('is_invalid', 0)
                    ->where('sys_resp_code', '00')
                    ->sum('amount');

            $logs->trade_count = $tradeCount;

            // 循环晋升条件 
            foreach ($Auto as $key => $value) {
                if($value->trade_count <= $tradeCount){
                    $this->group = $value->group_id;
                }else break;
            }

            $this->user->user_group = $this->group;
            $this->user->cur_verfity= 1;
            $this->user->save();

            $logs->biz = "上月团队交易达标C".$this->group.'用户的晋升条件,本月晋升至C'.$this->group.",晋升标准仅统计团队的非借记卡交易,非重复交易,非无效交易,成功交易订单";

            $logs->save();
            // 
        }catch (\Exception $e) {

            $logs = new \App\AutoPromotionLog;

            $logs->user_id = $this->user->id;

            $logs->operate = $this->user->operate;

            $logs->status = 0;

            $logs->biz    = $e->getMessage();

            $logs->save();

            return false;
        }
    }
}
