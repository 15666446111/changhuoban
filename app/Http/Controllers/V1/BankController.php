<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    
    /**
     * 查询联行号接口
     */
    public function openBank()
    {
        $host = "https://cnaps.market.alicloudapi.com";
        $path = "/lianzhuo/querybankaps";
        $method = "GET";
        $appcode = "2b98c225a8d24644959f3c7bcec08e23";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "bank=%E5%B7%A5%E5%95%86%E9%93%B6%E8%A1%8C&card=6226286336722163&city=%E6%B5%8E%E5%8D%97%E5%B8%82&key=%E6%A7%90%E8%8D%AB&page=1&province=%E5%B1%B1%E4%B8%9C%E7%9C%81";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        // var_dump(curl_exec($curl));
        return response()->json(['success'=>['message' => '获取成功!', ['data'  => curl_exec($curl) ]]]); 
    }

    public function feeFrozen($smsCode='', $posCharge='0', $simCharge='0')
    {
        $token = $this->getToken('2083');
        $url = $this->http.'/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/amountFrozen';
        $traceNo = $this->msectime();
        $postData = [
            'agentId' => $this->agentId,      // 渠道编号
            'token' => $token['data']['token'],     // 令牌
            'traceNo' => $traceNo,        // 请求流水号
            'merchId' => $merchants->merchId,      // 商户号
            'directAgentId' => $this->directAgentId,   // 商户直属代理商编号
            'sn' => $merchants->machines->sn,        // 终端SN序列号
            'posCharge' => \App\Machine::where('sn',$merchants->machines->sn)->first()->policys->active_price,       // POS服务费金额(元)
            'vipCharge' => '0',         // VIP会员服务费金额(元)
            'simCharge' => '0',       // SIM服务费金额(元)
            'smsSend' => '1',         // 是否发送短信(1发送 0不发送)
            'smsCode' => '20200426085542-0007',        // 短信模板编号
        ];
        $data = $this->send($url, $postData);
        return $data;
    }

    /**
     * 获取token
    */
    public function getToken($tokenType)
    {
        $url = $this->http.'/api/acq-channel-gateway/v1/acq-channel-auth-service/tokens/token';
        $postData['agentId'] = $this->agentId;
        $postData['tokenType'] = $tokenType;
        $data = $this->send($url, $postData);
        return $data;
    }

    /* 封装发送 */
    public function send($url='', $postData=[])
    {
        ksort($postData);
        $stringA = $this->key.implode('', $postData);
        $postData['sign'] = MD5($stringA);
        $data = $this->sendPost($url, json_encode($postData));
        return json_decode($data, true);
    }

    /*封装接口 起始位置*/
    public function sendPost($url,$jsonStr) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // 信任任何证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);        // 表示不检查证书
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response;
    }

    /**
     * 获取随机数
    */
    public function msectime() 
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $str = $msectime . mt_rand(100, 999);
        return $str;
    }

}
