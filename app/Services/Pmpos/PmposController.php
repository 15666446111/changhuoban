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
     * 直属机构编号
     * @var [type]
     */
    protected $directAgentId;

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
    public function __construct($merchantCode = false, $sn = false, $adminSetting = false)
    {

    	if(	$merchantCode ){

	    	$operate = \App\Merchant::where('code', $merchantCode)->value('operate');

	    	if (empty($operate)) {
	    		return array('status' =>false, 'message' => '该商户无所属操盘');
	    	}

	    	$adminSetting = \App\AdminSetting::where('operate_number', $operate)->first();

    	} elseif( $adminSetting ){

    		$adminSetting = $adminSetting;

    	} else {

    		return array('status' =>false, 'message' => '未找到配置信息!');
    	}

    	if (empty($adminSetting->system_merchant)) {
    		return array('status' =>false, 'message' => '操盘方3.0机构号未设置');
    	}

    	if (empty($adminSetting->system_merchant)) {
    		return array('status' =>false, 'message' => '操盘方3.0渠道秘钥未设置');
    	}

    	// 初始化机构号
    	$this->agentId = $adminSetting->system_merchant;

    	// 初始化直属机构编号
    	$this->directAgentId = $adminSetting->system_merchant;

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
	 * @param [type] $simCharge	SIM服务费金额(元)
	 */
	public function feeFrozen($smsCode='', $posCharge='0', $simCharge='0')
	{
		$token = $this->getToken('2083');

		$url = '/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/amountFrozen';

		$traceNo = $this->msectime();

		$postData = [
			'token' => $token,									// 令牌
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
		$data = $this->send($url, $postData, true);
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

		$url = '/api/acq-channel-gateway/v1/acq-channel-service/merchant/fee/updateNonAudit';

		$postData = [
			'token' 			=> $token,
			'merchId' 			=> $this->merchId,
			'cFeeRate' 			=> !empty($param['cFeeRate']) ? $param['cFeeRate'] : '',
			'dFeeRate' 			=> !empty($param['dFeeRate']) ? $param['dFeeRate'] : '',
			'dFeeMax' 			=> !empty($param['dFeeMax']) ? $param['dFeeMax'] : '',
			'wechatPayFeeRate' 	=> !empty($param['wechatPayFeeRate']) ? $param['wechatPayFeeRate'] : '',
			'alipayFeeRate' 	=> !empty($param['alipayFeeRate']) ? $param['alipayFeeRate'] : '',
			'ycFreeFeeRate' 	=> !empty($param['ycFreeFeeRate']) ? $param['ycFreeFeeRate'] : '',
			'ydFreeFeeRate' 	=> !empty($param['ydFreeFeeRate']) ? $param['ydFreeFeeRate'] : '',
			'd0FeeRate' 		=> !empty($param['d0FeeRate']) ? $param['d0FeeRate'] : 0,
			'd0SingleCashDrawal'=> !empty($param['d0SingleCashDrawal']) ? $param['d0SingleCashDrawal'] : 0,
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

		$url = '/api/acq-channel-gateway/v1/acq-channel-service/getMerchantFeeInfo';

		$postData = [
			'token' 	=> $token,
			'merchId' 	=> $this->merchId,
		];

		$data = $this->send($url, $postData);

		return $data;
	}

	/**
	 * 商户活动记录查询
	 */
	public function recordQuery()
	{
		$url = '/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/queryMerchWithAmtList';
		
		$postData['token'] 		= $this->getToken(2085);
		$postData['merchId'] 	= $this->merchId;
		$postData['sn'] 		= $this->merchSn;

		$data = $this->send($url, $postData);
		return $data;
	}

	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-09
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [获取短信模版]
	 * @return    [type]      [description]
	 */
	public function getSmsTemplate()
	{
		header("Content-type:text/html;charset=utf-8");

		$url   = '/api/acq-channel-gateway/v1/terminal-service/terms/activityReformV3/querySmsList';

		$postData['token'] = $this->getToken('2086');

		return json_decode($this->send($url, $postData));
	}

	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-09
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 获取token ]
	 * @param     [type]      $tokenType [description]
	 * @return    [type]                 [description]
	 */
	public function getToken($tokenType)
	{
		$url = '/api/acq-channel-gateway/v1/acq-channel-auth-service/tokens/token';

		$postData['tokenType'] = $tokenType;

		$data = $this->send($url, $postData);

		$data = json_decode($data);

		if($data->code == "00"){
			return $data->data->token;
		}else
			throw new Exception("token error", 1);
	}


	/* 封装发送 */
	public function send($url='', $postData=[], $jl = false)
	{
		$postData['agentId'] = $this->agentId;

		ksort($postData);

		$stringA = $this->key . implode('', $postData);


		$postData['sign'] 	  = MD5($stringA);

		$data = $this->sendPost($this->http . $url, json_encode($postData));

		return $jl ? ['return_data' => $data, 'send_data' => json_encode($postData)] : $data;
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
