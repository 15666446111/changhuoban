<?php

namespace App\Http\Controllers;

use App\Jobs\HandleTradeInfo;

use Illuminate\Http\Request;

class TradeApiController extends Controller
{
    
	/**
	 * [index 接收助代通(畅捷的推送信息)]
	 * @author Pudding
	 * @DateTime 2020-04-23T15:06:22+0800
	 * @return   [type]                   [description]
	 */
    public function index(Request $request)
    {

    	/**
    	 * @version [<vector>] [< 将推送过来的数据 压入到队列进行处理 >]
    	 */
    	HandleTradeInfo::dispatch(json_encode($request->all()))->onConnection('redis');

    	dd("SUCCESS");
	}
	

	/**
	 * 接收助代通(畅捷推送消息  用户注册通知接口)
	 */
	public function reg(Request $request)
	{
		dd($request->dataList);
		// 如果没有包含这两个值。则结束掉程序运行
        // 因为汇付接口传递过来的只有这两个参数 且必填
        if(!isset($request->dataList) or !isset($request->dataType))  return response()->json(['error'=>['message' => '请求出错!']]);

		if($request != 0 ){

			return response()->json(['error'=>['message' => '接收的不是开通通知内容!']]);

		}
   		// 接受请求数据
		$jsonData = $request->dataList;

		// 写入到推送信息
	    $trade_push = \App\RegisterNotice::create([
		    'title'		=>	'助代通注册通知接口',
		    'content'	=>	json_encode(array('data'=> json_decode($jsonData))),
		    'other'		=>	json_encode([
                '请求方式'  => $request->getMethod(), 
                '请求地址'  => $request->ip(), 
                '端口'     => $request->getPort(), 
                '请求头'   => $request->header('Connection')
            ]),
		]);
		
		$response   = json_decode($jsonData);

		foreach($response as $key=>$value){

			$regContent = \App\RegNoticeContent::create([
				//商户直属机构号
				'agentId'		=>		$value->agentId,
				//商户号
				'merchantId'	=>		$value->merchantId,
				//终端号
				'termId'		=>		$value->termId,
				//终端SN
				'termSn'		=>		$value->termSn,
				//终端型号
				'termModel'		=>		$value->termModel,
				//助贷通版本号
				'version'		=>		$value->version,

			]);
			
		}
		//压入到redis去处理剩下的逻辑
		HandleTradeInfo::dispatch(json_encode($regContent))->onConnection('redis');

    	dd("SUCCESS");
		   
	}
}
