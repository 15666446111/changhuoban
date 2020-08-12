<?php

namespace App\Jobs;

use App\MerchantsFrozenLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\ChanApiController;

class NewSimFrozen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * [$frozenLog 用来接收参数的变量]
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
     * [$pid 上次冻结记录的id，为二次和二次以上的冻结时，pid不为空]
     * @var [type]
     */
    protected $pid;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MerchantsFrozenLog $frozenLog)
    {
        $this->frozenLog = $frozenLog;

        if (!empty($this->frozenLog->pid)) {

            $this->pid = $this->frozenLog->pid;

            unset($this->frozenLog->pid);

        }

        // 初始化机具信息
        $this->machine = \App\Machine::where('sn', $frozenLog->sn)->first();

        // 初始化活动信息
        $this->policy = $this->machine->policy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->policy || empty($this->policy)) {
            $this->frozenLog->remark = '未获取到机具政策信息';
            $this->frozenLog->save();
            return false;
        }

        // 短信模板
        $smsCode = \App\AdminShort::where('id', $this->policy->sim_short_id)->value('template_id');
        if (empty($smsCode)) {
            $this->frozenLog->remark = '未配置短信模板';
            $this->frozenLog->save();
            return false;
        }

        try {

            // 实例化3.0接口类
            $pmposModel = new PmposController($this->machine->merchants->code, $this->machine->sn, true);

            // 发起冻结
            $data = $pmposModel->feeFrozen($smsCode, 0, $this->policy->sim_charge);

            $returnData = json_decode($data['return_data']);

            if ($returnData->code == '00') {
                // 更新冻结记录信息
                \App\MerchantsFrozenLog::where('id', $this->frozenLog->id)->update([
                    'state'         => 1,
                    'sim_agent_time'=> Carbon::now()->addMonth($this->policy->sim_cycle)->toDateTimeString(),
                    'return_data'   => $data['return_data'],
                    'send_data'     => $data['send_data']
                ]);

                // 更新流量卡费已冻结次数
                \App\Machine::where('id', $this->machine->id)->increment('sim_frozen_num', 1);

                // 更新已有冻结记录的下次冻结状态
                if (!empty($this->pid)) {
                    \App\MerchantsFrozenLog::where('id', $this->pid)->update(['sim_agent_state' => 1]);
                }
            }

        } catch (\Exception $e) {
            $this->frozenLog->remark = $this->frozenLog->remark . 'SIM服务费冻结:' . json_encode($e->getMessage());
            $this->frozenLog->save();
        }
    }
}
