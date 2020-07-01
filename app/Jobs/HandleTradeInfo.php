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
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($params)
    {
        $this->trade = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // if ($this->trade->) {
        //     # code...
        // }

    }
}
