<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class IndexController extends Controller
{	
	/**
	 * @version  [<首页 获取统计信息>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [返回首页中心模块 4个统计信息]
	 */
    public function info(Request $request)
    {
    	try{

            $model = new StatisticController($request->user, 'month');

            //　获取新增伙伴
            $MonthTeam      = $model->getNewAddTeamCount();

            //  获取新增商户
            $MonthMerchant  = $model->getNewAddMerchant();

            // 获取月交易额
            $MonthTrade     = number_format(($model->getTradeSum() / 100), 2, ".", "," );

            // 获取本月收益
            $MonthIncome   = 0;

            return response()->json(['success'=>
                    [
                        'message' => '获取成功!', 
                        'data' => [
                            'MonthTrade'    =>  $MonthTrade,
                            'MonthTeam'     =>  $MonthTeam,
                            'MonthIncome'   =>  $MonthIncome,
                            'MonthMerchant' =>  $MonthMerchant,
                        ]
                    ]
            ]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
