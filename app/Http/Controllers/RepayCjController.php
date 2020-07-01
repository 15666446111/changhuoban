<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepayCjController extends Controller
{
	// 代付接口请求地址
	public $http 		= 'https://pmpos.chanpay.com';
	protected $chanKey 	= '490306242EC25E03';	// 秘钥
	protected $agentId 	= '49030624';	// 商户号

    public function __construct(){

    }

    /**
     * 代付权限查询接口
     * @param string $value [description]
     */
    public function authQuery()
    {
    	
    	$url = $this->http . '/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/payment/auth/query';

    	$token = $this->getToken('2054');


    	$postData['agentId'] = $this->agentId;
    	$postData['token'] = $token['data']['token'];



    }

    /**
     * 获取token
     * @param  string $tokenType [description]
     * @return [type]            [description]
     */
    public function getToken($tokenType='')
    {
    	$url = $this->http . '/api/acq-channel-gateway/v1/acq-channel-auth-service/tokens/token';

    	$postData['agentId'] = $this->$agentId;
    	$postData['tokenType'] = $tokenType;

    	$data = $this->send($postData, $url);
    	return json_decode($data);
    }

    /** 
     * 封装发送
     */
    public function send($postData=[], $url='')
    {
    	ksort($postData);
    	$stringA = $this->chanKey . implode('',$postData);
        $postData['sign'] = md5($stringA);
        $data = $this->send_post($url ,json_encode($postData));
        return $data;
    }

    /**
     * post 请求接口
     * @param  [type] $url     [请求url]
     * @param  [type] $jsonStr [请求参数]
     * @return [type]          [description]
     */
    public function send_post($url, $jsonStr) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // 信任任何证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);        // 表示不检查证书
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array($httpCode, $response);
    }
}
