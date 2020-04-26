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
}
