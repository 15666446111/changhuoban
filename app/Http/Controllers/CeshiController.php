<?php

namespace App\Http\Controllers;

use App\Jobs\HandleTradeInfo;
use Illuminate\Http\Request;

class CeshiController extends Controller
{
    public function index()
    {
    	$tradeInfo = \App\Trade::where('trade_no', '20200814171802535893')->first();

    	foreach ($tradeInfo->cashs as $key => $value) {
    		
    		$money = $value->cash_money;

    		$userId = $value->user_id;

    		\App\UserWallet::where('user_id', $userId)->decrement('cash_blance', $money);

    		$value->delete();

    	}

    	HandleTradeInfo::dispatch($tradeInfo);

    	// $cash = new \App\Http\Controllers\CashController($tradeInfo);

        // $cashResult = $cash->cash();
    }
}
