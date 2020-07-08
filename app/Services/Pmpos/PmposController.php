<?php

namespace App\Services\Pmpos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PmposController extends Controller
{
	// 接口请求链接
    protected $http = 'https://pmpos.chanpay.com';

    /**
     * 机构号
     * @var [type]
     */
    protected $agentId;

    /**
     * 签名秘钥
     * @var [type]
     */
    protected $key;

    /**
     * 商户号
     * @var [type]
     */
    protected $merchId;

    /**
     * SN
     * @var [type]
     */
    protected $merchSn;

    /**
     * [__construct description]
     * @param [type] $merchantCode [description]
     * @param [type] $sn           [description]
     */
    public function __construct($merchantCode, $sn)
    {
    	$operate = \App\Merchant::where('code', $merchantCode)->value('operate');

    	$adminSetting = \App\AdminSetting::where('operate_number', $operate)->first();

    	if (empty($operate)) {
    		return array('status' =>false, 'message' => '该商户无所属操盘');
    	}

    	if (empty($adminSetting->system_merchant)) {
    		return array('status' =>false, 'message' => '操盘方3.0机构号未设置');
    	}

    	if (empty($adminSetting->system_merchant)) {
    		return array('status' =>false, 'message' => '操盘方3.0渠道秘钥未设置');
    	}

    	// 初始化机构号
    	$this->agentId = $adminSetting->system_merchant;

    	// 初始化秘钥
    	$this->key = $adminSetting->system_secret;

    	// 初始化商户号
    	$this->merchId = $merchantCode;

    	// 初始化sn号
    	$this->merchSn = $sn;

    }

	/**
	 * 商户服务费冻结
	 * @param [type] $smsCode	短信模板编号
	 * @param [type] $posCharge	POS服务费金额(元)
	 * @param [type] $simCharge	VIP会员服务费金额(元)
	 */
	public function feeFrozen($smsCode='', $posCharge='0', $simCharge='0')
	{
		$token = $this->getToken('2083');
		$url = $this->http.'/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/amountFrozen';
		$traceNo = $this->msectime();
		$postData = [
			'agentId' => $this->agentId,						// 渠道编号
			'token' => $token['data']['token'],					// 令牌
			'traceNo' => $traceNo,								// 请求流水号
			'merchId' => $this->merchId,						// 商户号
			'directAgentId' => $this->directAgentId,			// 商户直属代理商编号
			'sn' => $this->merchSn,								// 终端SN序列号
			'posCharge' => $posCharge,							// POS服务费金额(元)
			'vipCharge' => '0',									// VIP会员服务费金额(元)
			'simCharge' => $simCharge,							// SIM服务费金额(元)
			'smsSend' => '1',									// 是否发送短信(1发送 0不发送)
			'smsCode' => $smsCode,								// 短信模板编号
		];
		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * 商户服务费冻结查询
	 * @param  [type] $optNo [代收请求流水号]
	 * @return [type]        [description]
	 */
	public function queryFrozenOpt($optNo)
	{
		$token = $this->getToken('2084');
		$url = $this->http.'/api/acq-channel-gateway/v1/terminal-service/terms/activity/queryFrozenOpt';
		$postData = [
			'agentId' 	=> $this->agentId,
			'token' 	=> $token['data']['token'],
			'merchId' 	=> $this->merchId,
			'optNo' 	=> $optNo,
		];
		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * 商户服务费代收查询
	 * @param [type] optNo 	原操作序列号（商户服务费代收接口返回数据）
	 */
	public function amtQuery($optNo='')
	{
		$url = $this->http.'/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/queryAmtInfo';
		$token = $this->getToken('2087');
		$traceNo = $this->msectime();	// 请求流水号
		$postData = [
			'agentId' 	=> $this->agentId,
			'token' 	=> $token['data']['token'],
			'traceNo' 	=> $traceNo,
		];
		if (!empty($optNo)) {
			$postData['optNo'] = $optNo;
		}
		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * 商户费率信息修改(无审核)
	 */
	public function updateNonAudit($param=[])
	{
		header("Content-type:text/html;charset=utf-8");
		$token = $this->getToken('2061');
		if ($token['code'] != '00') {
			return $this->error('系统错误');
		}
		$url = $this->http.'/api/acq-channel-gateway/v1/acq-channel-service/merchant/fee/updateNonAudit';
		$postData = [
			'agentId' 			=> $this->agentId,
			'token' 			=> $token['data']['token'],
			'merchId' 			=> $this->merchId,
			'cFeeRate' 			=> $param['cFeeRate'],
			'dFeeRate' 			=> $param['dFeeRate'],
			'dFeeMax' 			=> $param['dFeeMax'],
			'wechatPayFeeRate' 	=> $param['wechatPayFeeRate'],
			'alipayFeeRate' 	=> $param['alipayFeeRate'],
			'ycFreeFeeRate' 	=> $param['ycFreeFeeRate'],
			'ydFreeFeeRate' 	=> $param['ydFreeFeeRate'],
		];
		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * 商户费率信息查询
	 */
	public function getMerchantFee()
	{
		$token = $this->getToken('2062');
		$url = $this->http.'/api/acq-channel-gateway/v1/acq-channel-service/getMerchantFeeInfo';
		$postData = [
			'agentId' 	=> $this->agentId,
			'token' 	=> $token['data']['token'],
			'merchId' 	=> $this->merchId,
		];
		$data = $this->send($url, $postData);
		return json_decode($data, true);
	}

	/**
	 * 商户活动记录查询
	 */
	public function recordQuery()
	{
		$tokenType = '2085';
		$token = $this->getToken($tokenType);
		$url = $this->http . '/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/queryMerchWithAmtList';
		
		$postData['agentId'] 	= $this->agentId;
		$postData['token'] 		= $token['data']['token'];
		$postData['merchId'] 	= $this->merchId;
		$postData['sn'] 		= $this->merchSn;

		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * 短信模板查询
	 */
	public function smsQuery()
	{
		header("Content-type:text/html;charset=utf-8");
		$tokenType = '2086';
		$token = $this->getToken($tokenType);
		if ($token['code'] != '00') {
			return $this->error('凭证获取失败');
		}
		$url = $this->http . '/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/querySmsList';
		$postData['agentId'] = $this->agentId;
		$postData['token'] = $token['data']['token'];

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
		$stringA = $this->key . implode('', $postData);
		$postData['sign'] = MD5($stringA);
		$data = $this->sendPost($url, json_encode($postData));
		return $data;
	}

	/*封装接口 起始位置*/
	public function sendPost($url,$jsonStr) {
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
	public function msectime() {
	    list($msec, $sec) = explode(' ', microtime());
	    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	    $str = $msectime . mt_rand(100, 999);
	    return $str;
  	}


}
