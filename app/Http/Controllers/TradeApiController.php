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

        // 推送的数据列表
        $dataList = $request->dataList;

        foreach ($dataList as $key => $value) {
            
        }
    	/**
    	 * @version [<vector>] [< 将推送过来的数据 压入到队列进行处理 >]
    	 */
    	HandleTradeInfo::dispatch(json_encode($request->all()))->onConnection('redis');


        $reData = [
            'configAgentId' => $request->configAgentId,    // 交易通知配置机构号
            'dataType' => $request->dataType,              // 推送数据类型，0：助贷通开通通知; 1：交易通知
            'sendBatchNo' => $request->sendBatchNo,        // 交易通知推送批次号
            'transDate' => $request->transDate,            // 交易日期yyyymmdd （收单系统，交易发生的日期）
            'revTime' => date('YmdHis', time()),           // 接收到交易流水的时间 yyyymmddhhmmss
            'responseCode' => '00',                        // 应答码
            'responseDesc' => "通知成功",                   // 应答描述
            'sign' => $request->sign                       // 签名
        ];
    	return json_encode($reData);
    }
}
