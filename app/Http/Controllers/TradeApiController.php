<?php

namespace App\Http\Controllers;

use App\Jobs\HandleTradeInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\TestController;

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

        // 写入到推送信息
        $trade_push = \App\RegisterNotice::create([
            'title'     =>  '畅捷同步通知推送接口',
            'content'   =>  json_encode(array('data'=> json_decode($request))),
            'other'     =>  json_encode([
                '请求方式'  => $request->getMethod(), 
                '请求地址'  => $request->ip(), 
                '端口'     => $request->getPort(), 
                '请求头'   => $request->header('Connection')
            ]),
        ]);

        // 同步返回数据
        $reData = [
            'configAgentId' => $request->configAgentId,    // 交易通知配置机构号
            'dataType'      => $request->dataType,         // 推送数据类型，0：助贷通开通通知; 1：交易通知
            'sendBatchNo'   => $request->sendBatchNo,      // 交易通知推送批次号
            'transDate'     => $request->transDate,        // 交易日期yyyymmdd （收单系统，交易发生的日期）
            'revTime'       => date('YmdHis', time()),     // 接收到交易流水的时间 yyyymmddhhmmss
            'responseCode'  => '00',                       // 应答码
            'responseDesc'  => "通知成功",                  // 应答描述
            'sign'          => $request->sign              // 签名
        ];

        // 推送的数据列表
        $dataList = json_decode($request->dataList);

        if ($request->dataType == 0) {
            // 商户开通通知处理
            
            foreach ($dataList as $key => $value) {

                $regContent = \App\RegNoticeContent::create([
                    //商户直属机构号
                    'agentId'       =>      $value->agentId,
                    //商户号
                    'merchantId'    =>      $value->merchantId,
                    //终端号
                    'termId'        =>      $value->termId,
                    //终端SN
                    'termSn'        =>      $value->termSn,
                    //终端型号
                    'termModel'     =>      $value->termModel,
                    //助贷通版本号
                    'version'       =>      $value->version,
                ]);

                //压入到redis去处理剩下的逻辑
                HandleTradeInfo::dispatch(json_encode($regContent))->onConnection('redis');
            }

        } else {
            // 交易通知处理
            
            foreach ($dataList as $key => $value) {

                // try{

                    // $value->sysRespCode != '00'  交易失败的数据
                    // $desc == '原交易已冲正'       无效冲正类交易
                    // 交易冲正时可能会推送多笔交易，已平台收单应答描述前六位为"原交易已冲正"区分是否为无效的冲正类交易，无效的交易信息不进行保存和处理
                    $desc = substr($value->sysRespDesc, 0, 18);
                    if ($value->sysRespCode != '00' || $desc == '原交易已冲正') {
                        continue;
                    }


                    // 新建交易订单 写入交易表 并且 分发到队列处理
                    $tradeOrder = \App\Trade::create([

                        // 交易通知配置机构号
                        'agt_merchant_id'   => $request->configAgentId,

                        // 交易日期
                        'transDate'         => $request->transDate,

                        // 交易码
                        'tranCode'          => $value->tranCode,

                        // 商户直属机构号
                        'agentId'           => $value->agentId,

                        // 凭证号
                        'traceNo'           => $value->traceNo,

                        // 系统流水号
                        'sysTraceNo'        => $value->sysTraceNo,

                        // 参考号
                        'rrn'               => $value->rrn,

                        // 输入方式
                        // 000  未指明
                        // 011  手工凭密
                        // 012  手工无密
                        // 021  磁条凭密
                        // 022  磁条无密
                        // 051  IC卡凭密
                        // 052  IC卡无密
                        // 071  闪付凭密
                        // 072  闪付无密
                        'inputMode'         => $value->inputMode,

                        // 卡类型 0:借记卡，1:信用卡
                        'cardType'          => $value->cardType,

                        // 商户号
                        'merchant_code'     => $value->merchantId,

                        // 终端号
                        'termId'            => $value->termId,

                        // 终端SN
                        'sn'                => $value->termSn,

                        // 交易金额，单位分
                        'amount'            => $value->amount,

                        // 交易金额，单位分
                        'settle_amount'     => $value->settleAmount,

                        // 手续费计算类型
                        // Y - 优惠
                        // M - 减免
                        // B - 标准
                        // YN - 云闪付NFC
                        // YM - 云闪付双免
                        'fee_type'          => $value->feeType,

                        // 收单平台应答码
                        'sysRespCode'       => $value->sysRespCode,

                        // 原交易日期yyyymmdd
                        'originalTranDate'  => !empty($value->originalTranDate) ?? null,
                        // 'originalTranDate'  => $value->originalTranDate,

                        // 原交易参考号
                        'originalRrn'       => !empty($value->originalRrn) ?? null,

                        // 原交易凭证号
                        'originaltraceNo'   => !empty($value->originaltraceNo) ?? null,

                    ]);


                    // 推送信息的不常用交易信息，另外储存到交易副表
                    \App\TradeDeputy::create([

                        // trades表id
                        'trade_id'          => $tradeOrder->id,
                        // 交易通知推送批次号
                        'sendBatchNo'       => $request->sendBatchNo,
                        // 交易时间
                        'tranTime'          => $value->tranTime,
                        // 卡号(带*)
                        'cardNo'            => $value->cardNo,
                        // 授权码
                        'authCode'          => $value->authCode,
                        // 终端批次号
                        'batchNo'           => $value->batchNo,
                        // 订单号
                        'orderId'           => $value->orderId,
                        // 发卡行
                        'bankName'          => $value->bankName,
                        // 助贷通版本号
                        'version'           => $value->version,
                        // 助贷通商户终端激活状态 0 - 未激活 1 - 已激活 2 - 已处理;
                        'activeStat'        => $value->activeStat,
                        // 助贷通活动终端绑定日期，当本笔交易为参与 3.0以下的助贷通活动的机具的交易 则必填
                        'termBindDate'      => $value->termBindDate,
                        // 商户类别 1 - A类商户； 2 - B类商户； 3 - C类商户； 4 - Z 类商户
                        'merchLevel'        => $value->merchLevel,
                        // 终端型号
                        'termModel'         => $value->termModel,
                        // 商户手机号
                        'mobileNo'          => $value->mobileNo,
                        // 商户名称
                        'merchantName'      => $value->merchantName,
                        // 清算日期
                        'settleDate'        => $value->settleDate,
                        // 收单平台应答描述
                        'sysRespDesc'       => $value->sysRespDesc,
                        // 原交易批次号
                        'originalbatchNo'   => $value->originalbatchNo,
                        // 原交易授权码
                        'originalAuthCode'  => $value->originalAuthCode,

                    ]);
                    
                    // 分发到队列 由队列去处理剩下的逻辑
                    // HandleTradeInfo::dispatch($tradeOrder);
                    
                    // 分润测试，正式环境需分发到队列中处理
                    $profit = new TestController($tradeOrder);
                    $profit->index();

                // } catch (\Exception $e) {

                //     $reData['responseCode'] = '01';
                //     $reData['responseDesc'] = '系统错误';

                // }

            }
        }
        
        

        return json_encode($reData);
    }
}
