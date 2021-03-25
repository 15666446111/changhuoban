<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Jobs\SimFrozen;
use Illuminate\Console\Command;

class SimDeducp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sim:Deducp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '流量卡冻结';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $startTime = Carbon::today();

        $endTime   = Carbon::tomorrow();

        // 当日的待发起冻结订单
        $frozenLog = \App\MerchantsFrozenLog::where('type', 2)->where('state', 0)->whereBetween('sim_agent_time', [$startTime, $endTime])->get();

        foreach ($frozenLog as $key => $value) {
            // 压入队列处理剩下的逻辑
            SimFrozen::dispatch($value)->onQueue('SimFrozen');
        }
    }
}
