<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TradeController extends Controller
{
    

	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-05
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 获取交易详情 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function getDetail(Request $request)
    {
			
			/**
			 * [$user 获取查询的用户]
			 * @var [type]
			 */
    		$user = $request->uid ?? $request->user->id;

    		$user = \App\User::where('id', $user)->first();

    		if(!$user or empty($user)){
    			return response()->json(['error'=>['message' => '无此用户!', 'data'=>[]]]);
    		}

			// 按日  按月  day 按照天。 month 按月
			// 日期。月份参数
			// 本人  团队  传过来的参数为 current 本人 或者 team  团队
			$current 	= $request->current ?? 'current';

			$dataType   = $request->data_type ?? 'day';

			$server = new \App\Http\Controllers\V1\ServerController($dataType, $current, $user);

			$data   = $server->getInfo();

			return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 
		

    	
    }
}
