<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncTrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tradeData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tradeData)
    {
        $this->tradeData = $tradeData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $kmmUrl = 'http://kmm.op-server.com/trade';
        $client     = new Client();
        $response   = $client->request('POST', $kmmUrl, [
            'json'  =>  json_decode(json_encode($this->tradeData, JSON_UNESCAPED_UNICODE), true),
        ]);

        return 'true';
    }
}
