<?php
namespace App\Admin\ShowModel;

use Encore\Admin\Widgets\Table;
use Illuminate\Contracts\Support\Renderable;

class ShowUserCount implements Renderable
{

    public function render($key = null)
    {
    	$User = \App\User::find($key);

		$headers = ['分润余额', '返现余额', '机器总数', '团队人数', '总收益'];

		$rows = [
		    [
		    	number_format($User->wallets->cash_blance, 2, '.', ',')."元", 
		    	number_format($User->wallets->return_blance, 2, '.', ',')."元", 
		    	number_format($User->machines->count())."台",
		    	number_format(\App\UserRelation::where('parents', 'like', "%\_".$User->id."\_%")->count())."人",
		    	number_format($User->cash->sum('cash_money') / 100, 2, ".", ",")."元",
		    ],
		];

		$table = new Table($headers, $rows);

		echo $table->render();
    }
}