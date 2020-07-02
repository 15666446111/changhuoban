<?php
namespace App\Services\Cj;

use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepayCjController extends Controller
{
    /**
     * [$withdraw 提现的模型 ]
     * @var [ ORM ]
     */
    protected $withdraw;

    /**
     * [$setting 操盘方的设置表信息 ]
     * @var [ ORM ]
     */
    protected $setting;

    /**
     * [$baseHttp 代付接口的基础域名 ]
     * @var [ URL ]
     */
    protected $baseHttp = 'https://pmpos.chanpay.com';

    /**
     * [$agentId 畅捷代付的商户号]
     * @var [ string ]
     */
    protected $agentId;


    /**
     * [$chanKey 畅捷代付的密钥 ]
     * @var [ string ]
     */
	protected $chanKey;

    /**
     * [$cjPrice 畅捷方应扣除的金额 加单笔提现费 节假日 周六周末不扣 ]
     * @var [ int ]
     */
    protected $cjPrice;

    /**
     * [$price 畅捷方单笔代付费 单位 分]
     * @var integer
     */
    protected $price = 20;

    /**
     * [$desc 节假日说明]
     * @var string
     */
    protected $desc  = ""; 

    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @param     Withdraw    $Withdraw [ 提现的模型 ]
     * @version   [ 初始化方法]
     */
    public function __construct( Withdraw $Withdraw )
    {

        $this->withdraw = $Withdraw;

        $this->setting = \App\Setting::where('operate', $this->withdraw->operate)->first();

        $adminSetting  = \App\AdminSetting::where('operate_number', $this->withdraw->operate)->first();

        $this->agentId = empty($adminSetting) ? "" : $adminSetting->payment_merchant;

        $this->chanKey = empty($adminSetting) ? "" : $adminSetting->payment_secret;

        $url = "http://api.goseek.cn/Tools/holiday?date=20200701";

        //
        $now = Carbon::now()->toDateTimeString();

        // 查询是否在节假日日期内
        $holiday = \App\Holiday::where('start_time', '<=', $now)->where('end_time', '>=', $now)->first();

        if(empty($holiday) or !$holiday){

            //如果不在节假日 判断是否是周六或者周日
            $week = Carbon::now()->dayOfWeek;
            // 如果是周六周末， 也不进行单笔扣费
            if($week == 6 or $week == 0){

                $this->cjPrice = $this->withdraw->real_money;

                $this->desc    =  "非节假日的周六周日:畅捷代付不扣单笔提现费!";

            } else {

                $this->cjPrice = $this->withdraw->real_money + $this->price;

                $this->desc    =  "工作日:畅捷代付扣单笔提现费:".number_format( $this->price /100 ,2, '.', ',')."元!";
            }

        }else{

            $this->cjPrice = $this->withdraw->real_money;

            $this->desc    =  "节假日:".$holiday->title."/畅捷代付不扣单笔提现费!";
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 后台审核提现订单 ]
     * @param     string      $password [ 输入的审核密码 ]
     * @return    [type]                [description]
     */
    public function apply( string $password )
    {
        try{

            if($this->withdraw->state != "1" ) return ['code' => 10010, 'message' => '该笔订单已经处理过!'];

            if($this->withdraw->make_state != "0" ) return ['code' => 10011, 'message' => '该笔订单已经处理过!'];

            if(!$this->setting or empty($this->setting)) return ['code' => 10031, 'message' => '未找到配置信息!'];
            
            if($this->agentId == "") return ['code' => 10033, 'message' => '未找到代付设置参数信息!'];

            if($this->chanKey == "") return ['code' => 10033, 'message' => '未找到代付设置参数信息!'];

            //if($password != $this->setting->withdraw_pass) return ['code' => 10050, 'message' => '审核密码不正确!'];

            if($this->setting->withdraw_open != "1") return ['code' => 10050, 'message' => '您未开启提现,请在设置中开启提现功能!'];

            return $this->run();

        } catch (Exception $e) {

            return $this->response()->error('错误:'.$e->getMessage());

        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [执行代付接口]
     * @return    [type]      [description]
     */
    public function run()
    {
        #### 
        ####    检查是否有代付权限
        ####
        $auth = $this->authQuery();
        // 未开通代付权限的情况下。去开通代付权限
        if($auth->data->enterprisePaymentStatus != "1"){
            $this->applyAuth();
        }

        #### 
        ####    检查商户余额是否足够
        ####
        $blanceResult = $this->blanceQuery();
        // 当畅捷方商户余额不足的时候 结束
        if($blanceResult->data->b2bT1Wallet * 100 <= $this->cjPrice ){
            return ['code' => 10100, 'message' => '您的畅捷代付中商户余额不足!'];
        }

        #### 
        ####    发起代付
        ####
        $pay = $this->pay();


        return $pay;

    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取请求token ]
     * @param     [string]      $tokenType [ 令牌类型 ]
     * @return    [string]                 [ 返回令牌字符串 ]
     */
    public function getToken($tokenType ='' )
    {   
        // 获取token的地址
        $url = '/api/acq-channel-gateway/v1/acq-channel-auth-service/tokens/token';

        $res = $this->send(array('agentId' => $this->agentId, 'tokenType' => $tokenType), $url);

        return $res;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [代付接口权限检查]
     * @return    [type]      [description]
     */
    public function authQuery()
    {
        // 检查权限的url
        $url   = '/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/payment/auth/query';

        // 获取到token
        $token = $this->getToken('2054');

        // 代理商商户号
        $postData['agentId'] = $this->agentId;

        $postData['token']   = $token->data->token;

        $res = $this->send($postData, $url);

        return $res;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [开通代付权限]
     * @return    [type]      [description]
     */
    public function applyAuth()
    {
        // 开通权限的url
        $url = "/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/payment/auth/update";
        // 获取到token
        $token = $this->getToken('2055');

        // 代理商商户号
        $postData['agentId'] = $this->agentId;

        $postData['token']   = $token->data->token;

        $postData['enterprisePaymentStatus'] = 1;

        $res = $this->send($postData, $url);

        return $res;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [查询商户余额是否足够]
     * @return    [type]      [description]
     */
    public function blanceQuery()
    {   
        // 商户余额查询地址
        $url = "/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/balance";
        // 获取到token
        $token = $this->getToken('2050');
        // 代理商商户号
        $postData['agentId'] = $this->agentId;

        $postData['token']   = $token->data->token;

        $res = $this->send($postData, $url);

        return $res;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [发起代付]
     * @return    [type]      [description]
     */
    public function pay()
    {
        return ['code' => 10010, 'message' => 'cuow!'];
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 发送获取请求的token令牌 ]
     * @param     array       $postData [description]
     * @param     string      $url      [description]
     * @return    [type]                [description]
     */
    public function send( $postData=[], $url='' )
    {
        # 排序
        ksort($postData);
        # 密钥链接字符串
        $stringA = $this->chanKey . implode('',$postData);
        # 获取签名
        $postData['sign'] = md5($stringA);
        # 获得返回数据
        $data = $this->send_post($this->baseHttp . $url ,json_encode($postData));
        # 返回结果
        return json_decode($data);
    }

    /**
     * post 请求接口
     * @param  [type] $url     [请求url]
     * @param  [type] $jsonStr [请求参数]
     * @return [type]          [description]
     */
    public function send_post($url, $jsonStr) 
    {
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

        return $response;
        //return array($httpCode, $response);
    }
}
