<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MachineConfig extends Controller
{
   
    /**
     * 获取token
    */
    public function getToken($tokenType)
    {
        $url = 'https://pmpos.chanpay.com/api/acq-channel-gateway/v1/acq-channel-auth-service/tokens/token';
        $postData['agentId'] = $this->agentId;
        $postData['tokenType'] = $tokenType;
        $data = $this->send($url, $postData);
        return $data;
    }

    /* 封装发送 */
    public function send($url='', $postData=[],$key = '')
    {
        ksort($postData);
        $stringA = $key.implode('', $postData);
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
