<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\HandleTradeInfo;
use App\Jobs\HandleMachineInfo;

use GuzzleHttp\Client;
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
            'content'   =>  json_encode(array('data'=> $request->all())),
            'other'     =>  json_encode([
                '请求方式'  => $request->getMethod(), 
                '请求地址'  => $request->ip(), 
                '端口'     => $request->getPort(), 
                '请求头'   => $request->header('Connection')
            ]),
        ]);

        // 同步返回的数据
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

        ## 签名验证
        $key = '16D0462C164CB0E3AD6EF2B0B9514092';

        // 参与验签的数据
        $signData = [
            'configAgentId' => $request->configAgentId,
            'sendBatchNo'   => $request->sendBatchNo,
            'sendTime'      => $request->sendTime,
            'sendNum'       => $request->sendNum,
            'transDate'     => $request->transDate,
            'dataType'      => $request->dataType,
        ];

        // 1.按照参数名ASCII码从小到大排序
        ksort($signData);

        // 2.将key和参数值拼接成字符串
        $stringA = $key . implode('', $signData);

        // 3.将拼接的字符串进行md5加密
        $reData['sign'] = MD5($stringA);
        
        if ($request->sign != MD5($stringA)) {
            $reData['responseCode'] = '01';
            $reData['responseDesc'] = '验签失败';
            $reData['revTime'] = date('YmdHis', time());
            return response()->json($reData);
        }

        $dataList = json_decode(json_encode($request->dataList));
        
        // 卡妈妈交易数据转发
        if ($request->configAgentId == '49059502') {
            $kmmUrl = 'http://kmm.changhuoban.com/public/getList/transaction';
            $client     = new Client();
            $response   = $client->request('POST', $kmmUrl, [
                'json'  =>  json_decode(json_encode($request->all(), JSON_UNESCAPED_UNICODE), true),
            ]);
            $content    = json_decode($response->getBody()->getContents(), true);

            // 转发到新平台
            // $kmmNewUrl = 'http://kmm.op-server.com/trade';
            // $client->request('POST', $kmmNewUrl, [
            //     'json'  =>  json_decode(json_encode($request->all(), JSON_UNESCAPED_UNICODE), true),
            // ]);

            return response()->json($content);
        }

        if ($request->dataType == 0) {
            // 商户开通通知处理
            try{

                foreach ($dataList as $key => $value) {

                    $regContent = \App\RegNoticeContent::create([
                        //商户通知配置机构号
                        'config_agent_id'       =>      $request->configAgentId,
                        //商户直属机构号
                        'agentId'               =>      $value->agentId,
                        //商户号
                        'merchantId'            =>      $value->merchantId,
                        //终端号
                        'termId'                =>      $value->termId,
                        //终端SN
                        'termSn'                =>      $value->termSn,
                        //终端型号
                        'termModel'             =>      $value->termModel,
                        //助贷通版本号
                        'version'               =>      $value->version ?? '',
                    ]);
                    
                    //压入到队列去处理剩下的逻辑
                    HandleMachineInfo::dispatch($regContent)->onQueue('merchant_open');
                    
                    // 开通通知测试，正式环境需分发到队列中处理
                    // $profit = new TestMerchantController($regContent);
                    // $profit->index();

                }

            } catch (\Exception $e) {

                $reData['responseCode'] = '01';
                $reData['responseDesc'] = $e->getMessage();

            }
            
        } else {
            // 交易通知处理
            
            foreach ($dataList as $key => $value) {

                try{

                    // $value->sysRespCode != '00'  交易失败的数据
                    // $desc == '原交易已冲正'       无效冲正类交易
                    // 交易冲正时可能会推送多笔交易，已平台收单应答描述前六位为"原交易已冲正"区分是否为无效的冲正类交易，无效的交易信息不进行保存和处理
                    // $desc = substr($value->sysRespDesc, 0, 18);
                    // if ($value->sysRespCode != '00' || $desc == '原交易已冲正') {
                    //     continue;
                    // }
                    // 交易时间
                    $tranTime = Carbon::createFromFormat('YmdHis', $value->tranTime)->toDateTimeString();

                    $tradeData = [

                        // 交易通知配置机构号
                        'trade_no'   => $request->transDate . $value->rrn,

                        // 交易通知配置机构号
                        'agt_merchant_id'   => $request->configAgentId,

                        // 交易日期
                        'trans_date'        => $request->transDate,

                        // 交易日期
                        'trade_time'        => $tranTime,

                        // 交易码
                        'tran_code'         => $value->tranCode,

                        // 商户直属机构号
                        'agent_id'          => $value->agentId,

                        // 凭证号
                        'trace_no'          => $value->traceNo ?? 0,

                        // 系统流水号
                        'sys_trace_no'      => $value->sysTraceNo,

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
                        'input_mode'        => $value->inputMode ?? 0,

                        // 卡类型 0:借记卡，1:信用卡
                        'card_type'         => $value->cardType ?? null,

                        // 商户号
                        'merchant_code'     => $value->merchantId,

                        // 商户手机号
                        'merchant_phone'    => $value->mobileNo ?? '',

                        // 商户名称
                        'merchant_name'     => $value->merchantName,

                        // 终端号
                        'term_id'           => $value->termId ?? '',

                        // 终端SN
                        'sn'                => $value->termSn ?? '',

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
                        'sys_resp_code'     => $value->sysRespCode,

                        // 收单平台应答描述
                        'sys_resp_desc'     => $value->sysRespDesc,

                        // 原交易日期yyyymmdd
                        'original_tran_date'=> $value->originalTranDate ?? null,

                        // 原交易参考号
                        'original_rrn'      => $value->originalRrn ?? null,

                        // 原交易凭证号
                        'original_trace_no' => $value->originaltraceNo ?? null

                    ];

                    $reduceTranCode = [
                        '020002' => '消费撤销',
                        '020003' => '消费冲正',
                        'T20003' => '日结消费冲正',
                        '024102' => '预授权完成撤销',
                        '024103' => '预授权完成冲正',
                        '02Y600' => '银联二维码撤销',
                    ];

                    // 为冲正和撤销类交易时，交易金额和结算金额储存负值
                    if (!empty($reduceTranCode[$value->tranCode])) {
                        $tradeData['amount']        = $value->amount * -1;
                        $tradeData['settle_amount'] = $value->settleAmount * -1;
                    }


                    // 新建交易订单 写入交易表
                    $tradeOrder = \App\Trade::create($tradeData);


                    // 推送信息的不常用交易信息，另外储存到交易副表
                    \App\TradesDeputy::create([
                        // trades表id
                        'trade_id'          => $tradeOrder->id,
                        // 交易通知推送批次号
                        'sendBatchNo'       => $request->sendBatchNo,
                        // 卡号(带*)
                        'cardNo'            => $value->cardNo ?? '',
                        // 授权码
                        'authCode'          => $value->authCode ?? '',
                        // 终端批次号
                        'batchNo'           => $value->batchNo ?? 0,
                        // 订单号
                        'orderId'           => $value->orderId ?? '',
                        // 发卡行
                        'bankName'          => $value->bankName ?? '',
                        // 助贷通版本号
                        'version'           => $value->version ?? '' ,
                        // 助贷通商户终端激活状态 0 - 未激活 1 - 已激活 2 - 已处理;
                        'activeStat'        => $value->activeStat ?? '',
                        // 助贷通活动终端绑定日期，当本笔交易为参与 3.0以下的助贷通活动的机具的交易 则必填
                        'termBindDate'      => $value->termBindDate ?? '',
                        // 商户类别 1 - A类商户； 2 - B类商户； 3 - C类商户； 4 - Z 类商户
                        'merchLevel'        => $value->merchLevel,
                        // 终端型号
                        'termModel'         => $value->termModel ?? '',
                        // 清算日期
                        'settleDate'        => $value->settleDate ?? 0,
                        // 原交易批次号
                        'originalbatchNo'   => $value->originalbatchNo ?? '',
                        // 原交易授权码
                        'originalAuthCode'  => $value->originalAuthCode ?? ''

                    ]);
                    
                    // 分发到队列 由队列去处理剩下的逻辑
                    // 为冲正和撤销类交易时，延迟5分钟后执行
                    if (!empty($reduceTranCode[$value->tranCode])) {
                        
                        HandleTradeInfo::dispatch($tradeOrder)->onQueue('trade')->delay(now()->addMinutes(5));

                    // 撤销冲正类交易，延迟10分钟后执行
                    } else if ($value->tranCode == '020023' || $value->tranCode == '024123') {
                        
                        HandleTradeInfo::dispatch($tradeOrder)->onQueue('trade')->delay(now()->addMinutes(10));

                    } else {

                        HandleTradeInfo::dispatch($tradeOrder)->onQueue('trade');
                        // HandleTradeInfo::dispatch($tradeOrder);

                    }
                    
                    
                    // 分润测试，正式环境需分发到队列中处理
                    // $profit = new TestController($tradeOrder);
                    // $profit->index();

                } catch (\Exception $e) {

                    $reData['responseCode'] = '01';
                    $reData['responseDesc'] = '系统错误';

                }

            }
        }
        
        return response()->json($reData);
    }
}
