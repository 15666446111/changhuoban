<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CeshiController extends Controller
{
    public function index()
    {
    	$tradeInfo = \App\Trade::where('trade_no', '20200814171721534064')->first();

    	$cash = new \App\Http\Controllers\CashController($tradeInfo);

        $cashResult = $cash->cash();
    }
}
