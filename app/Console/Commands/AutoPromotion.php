<?php

namespace App\Console\Commands;

use App\Jobs\AutoPromotion as JobAutoPromotion;
use Illuminate\Console\Command;

class AutoPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_promotion:verfity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users who execute alliance mode are automatically promoted to audit at 1:00 a.m. on the 1st of every month';

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
        // 获取联盟模式的操盘方， 并且获取到联盟模式的用户， 压入到队列
        $User = \App\User::whereHasIn('operates', function ($query) {
                    $query->where('pattern', 1)->where('type', 1);
                })->get();

        foreach ($User as $key => $value) {

            JobAutoPromotion::dispatch($value)->onQueue('AutoPromotion');

        }

    }
}
