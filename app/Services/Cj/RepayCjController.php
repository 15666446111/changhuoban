<?php
namespace App\Services\Cj;

use App\Withdraw;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Jobs\WithdrawQuery;
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
     * [$chbPrice 畅伙伴代付单笔代付费 ]
     * @var integer
     */
    protected $chbPrice = 100;

    /**
     * [$desc 节假日说明]
     * @var string
     */
    protected $desc  = ""; 


    protected $iv;

    /**
     * [$isAdd 是否加单笔提现费]
     * @var boolean
     */
    protected $isHoliday = true;

    /**
     * [$adminSetting 操盘方设置]
     * @var [ORM]
     */
    protected $adminSetting;

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
        $this->withdraw = \App\Withdraw::where('id', $Withdraw->id)->first();

        $this->setting  = \App\Setting::where('operate', $this->withdraw->operate)->first();

        $adminSetting   = \App\AdminSetting::where('operate_number', $this->withdraw->operate)->first();

        $this->adminSetting = $adminSetting;

        $this->agentId  = empty($adminSetting) ? "" : $adminSetting->payment_merchant;

        $this->chanKey  = empty($adminSetting) ? "" : $adminSetting->payment_secret;


        $now        = Carbon::now()->toDateTimeString();
        $holiday    = \App\Holiday::where('start_time', '<=', $now)->where('end_time', '>=', $now)->first();
        if(empty($holiday)){
            //如果不在节假日 判断是否是周六或者周日
            $week = Carbon::now()->dayOfWeek;
            if($week == 6 or $week == 0){
                $yesterday  = Carbon::now()->subDays(1)->toDateTimeString();
                $is_Holiday = \App\Holiday::where('start_time', '<=', $yesterday)->where('end_time', '>=', $yesterday)->exists();
                if( $is_Holiday ) $this->isHoliday  = false;
            }else
                $this->isHoliday = false;
        }


        if($adminSetting->payment_type=="1"){
            $this->cjPrice =  $this->withdraw->real_money + $this->chbPrice;
            $this->desc    =  "工作日:畅伙伴代付扣单笔提现费:".number_format( $this->chbPrice /100 ,2, '.', ',')."元!";
        }else{

            if($this->isHoliday){
                $this->cjPrice =    $this->withdraw->real_money;
                $this->desc    =    "节假日:".$holiday->title."/畅捷代付不扣单笔提现费!";
            }else{
                $this->cjPrice =  $this->withdraw->real_money + $this->price;
                $this->desc    =  "工作日:畅捷代付扣单笔提现费:".number_format( $this->price /100 ,2, '.', ',')."元!";
            }
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
            if($password != $this->setting->withdraw_pass) return ['code' => 10050, 'message' => '审核密码不正确!'];
            if($this->setting->withdraw_open != "1") return ['code' => 10050, 'message' => '您未开启提现,请在设置中开启提现功能!'];
            // 提现流程
            return $this->run();

        } catch (Exception $e) {
            return $this->response()->error('错误:'.$e->getMessage());
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function auto_apply()
    {

        if($this->withdraw->state != "1" ) return ['code' => 10010, 'message' => '该笔订单已经处理过!'];

        if($this->withdraw->make_state != "0" ) return ['code' => 10011, 'message' => '该笔订单已经处理过!'];

        if(!$this->setting or empty($this->setting)) return ['code' => 10031, 'message' => '未找到配置信息!'];
        
        if($this->agentId == "") return ['code' => 10033, 'message' => '未找到代付设置参数信息!'];

        if($this->chanKey == "") return ['code' => 10033, 'message' => '未找到代付设置参数信息!'];

        if($this->setting->withdraw_open != "1") return ['code' => 10050, 'message' => '您未开启提现,请在设置中开启提现功能!'];

        $run = $this->run();
        
        $this->withdraw->api_return_data = json_encode($run);
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
        ####    检查代付参数  发起代付
        ####
        if(!$this->withdraw->withdrawDatas) return ['code' => 10060, 'message' => '找不到提现卡信息!'];

        // 收款方卡号
        if($this->withdraw->withdrawDatas->bank_number == "") return ['code' => 10062, 'message' => '找不到收款卡信息!'];
        $AccountBank = $this->des3($this->withdraw->withdrawDatas->bank_number);

        //$身份证号
        if($this->withdraw->withdrawDatas->idcard == "") return ['code' => 10062, 'message' => '找不到身份证信息!'];
        $idCardNo    = $this->des3($this->withdraw->withdrawDatas->idcard);

        // 收款方姓名
        if($this->withdraw->withdrawDatas->username == "") return ['code' => 10063, 'message' => '收款方姓名不能为空!'];

        // 收款方银行名称
        if($this->withdraw->withdrawDatas->bank == "") return ['code' => 10063, 'message' => '收款方银行名称不能为空!'];

        // 收款方联行号
        if($this->withdraw->withdrawDatas->banklink == "") return ['code' => 10063, 'message' => '收款方联行号不能为空!'];


        if($this->adminSetting->payment_type == "1"){

            ####。 执行畅伙伴代付  TODO::
            $pay        = $this->chbPay($AccountBank, $idCardNo);

            if($pay['code'] == "200"){

                $this->withdraw->state = 4;

                $this->withdraw->check_at = Carbon::now()->toDateTimeString();

                $this->withdraw->channle_money = $this->cjPrice;

                $this->withdraw->api_return_data = json_encode($pay);

                $this->withdraw->save();

                // 押入redis队列处理  30分钟后查询
                WithdrawQuery::dispatch($this->withdraw)->onQueue('withdraw')->delay(now()->addMinutes(10));
                return ['code' => 10000, 'message' => "代付交易已受理,订单状态会在10分钟内自动同步更新!"];

            } elseif ($pay['code'] == "20010") {
                
                $this->withdraw->state = -1;

                $this->withdraw->check_at = Carbon::now()->toDateTimeString();

                $this->withdraw->channle_money = $this->cjPrice;

                $this->withdraw->api_return_data = json_encode($pay);

                $this->withdraw->save();

                return ['code' => 10000, 'message' => "代付交易已受理,因十一假期原因，代付系统拥堵，提现将在24小时内到账"];

            } else{
                // 请求代付失败
                return ['code' => 10099, 'message' => $pay['message'] ];
            }


        } else {

            ####    检查是否有代付权限
            $auth = $this->authQuery();

            ####    未开通代付权限的情况下。去开通代付权限
            if($auth->data->enterprisePaymentStatus != "1"){
                $this->applyAuth();
            }

            ####    检查商户余额是否足够
            $blanceResult = $this->blanceQuery();

            ####    当畅捷方商户余额不足的时候 结束
            if($blanceResult->data->b2bT1Wallet * 100 <= $this->cjPrice ){
                return ['code' => 10100, 'message' => '您的畅捷代付中商户余额不足!'];
            }

            // 请求代付
            $pay = $this->pay($AccountBank, $idCardNo);

            // 交易受理的情况下 更改订单信息 压入redis
            if($pay->code == "00"){

                $this->withdraw->state = 4;

                $this->withdraw->check_at = Carbon::now()->toDateTimeString();

                $this->withdraw->channle_money = $this->cjPrice;

                $this->withdraw->api_return_data = json_encode($pay);

                $this->withdraw->save();

                // 押入redis队列处理  30分钟后查询
                WithdrawQuery::dispatch($this->withdraw)->onQueue('withdraw')->delay(now()->addMinutes(10));

                return ['code' => 10000, 'message' => "代付交易已受理,订单状态会在10分钟内自动同步更新!"];
           
            }else{
                // 请求代付失败
                return ['code' => 10099, 'message' => $pay->message];
            }

        }

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
    public function pay($bankNo, $cardNo)
    {
        // 商户余额查询地址
        $url = "/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/payment/without";
        // 获取到token
        $token = $this->getToken('2051');
        // 代理商商户号
        $postData['agentId'] = $this->agentId;

        $postData['token']   = $token->data->token;

        $postData['amount']  = $this->cjPrice / 100;

        $postData['bankAccountNo']  = $bankNo;

        $postData['bankAccountName']= $this->withdraw->withdrawDatas->username;

        $postData['idCardNo']       =  $cardNo;

        $postData['bankAccountType']= 'S';

        $postData['bankName']       = $this->withdraw->withdrawDatas->bank;

        $postData['bankChannelNo']  = $this->withdraw->withdrawDatas->banklink;

        $postData['traceNo']        = $this->withdraw->order_no;

        $postData['paymentType']    = '1';

        $res = $this->send($postData, $url);

        return $res;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 畅伙伴代付 ]
     * @param     [type]      $bankNo [description]
     * @param     [type]      $cardNo [description]
     * @return    [type]              [description]
     */
    public function chbPay($bankNo, $cardNo)
    {
        ### 获取token
        $tokenResult = $this->getChbToken();

        if($tokenResult['code'] != "200" or !isset($tokenResult['token']) ){
            $this->withdraw->api_return_data = json_encode(array('code' => '10100', 'message' => "畅伙伴代付出错: 未获取到token!" ));
            $this->withdraw->save();
            throw new \Exception(" 畅伙伴代付出错: 未获取到token!");
        }

        #### 执行畅伙伴代付 -- 直接打款 
        $payUrl     = "http://qb.changhuoban.com/api/index/index";

        $payData    = array(
            'agentId'   =>  $this->agentId,
            'amount'    =>  $this->isHoliday ? $this->withdraw->real_money / 100  : ($this->withdraw->real_money + $this->price) / 100,
            'beMoney'   =>  $this->withdraw->real_money / 100,
            'bankAccountNo'     =>  $bankNo,
            'bankAccountName'   =>  $this->withdraw->withdrawDatas->username,
            'idCardNo'          =>  $cardNo,
            'bankAccountType'   =>  'S',
            'bankName'          =>  $this->withdraw->withdrawDatas->bank,
            'bankChannelNo'     =>  $this->withdraw->withdrawDatas->banklink,
            'traceNo'           =>  $this->withdraw->order_no,
            'paymentType'       =>  '1',
            'token'             =>  $tokenResult['token'],
        );

        # 排序
        ksort($payData);
        # 密钥链接字符串
        $stringA = $this->chanKey . implode('',$payData);
        # 获取签名
        $payData['sign'] = md5($stringA);

        #####  guzz 请求
        $client     = new Client();
        $response   = $client->request('POST', $payUrl, [
            'json'  =>  $payData,
        ]);
        $content    = json_decode($response->getBody()->getContents(), true);

        if(!is_array($content)){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅伙伴代付出错: 返回非数组类型!" ));
            $this->withdraw->save();
            throw new \Exception(" 畅伙伴代付出错: 返回非数组类型!");
        } 

        if(!$content['code']){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅伙伴代付出错: 返回非标识码!" ));
            $this->withdraw->save();
            throw new \Exception(" 畅伙伴代付出错: 返回非标识码!");
        } 
        //echo json_encode($postData).$this->chanKey."<br/>";
        if($content['code'] != "200" && $content['code'] != "20010"){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅伙伴代付出错: ".$content['msg'] ));
            $this->withdraw->save();
            throw new \Exception(" 畅伙伴代付出错:".$content['msg']);
        }

        return $content;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-08-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取畅伙伴代付的token ]
     * @return    [type]      [description]
     */
    public function getChbToken()
    {
        #### 请求token的url
        $url    =   "http://qb.changhuoban.com/api/index/token";
        ####。请求参数
        $data   =  array('agentId' => $this->agentId);
        ####  参数名ASCII码从小到大排序（字典序）;
        ksort($data); 
        ####  拼接API密钥
        $stringA = $this->chanKey.implode('',$data);
        ####  md5加密
        $data['sign'] = md5($stringA);

        #####  guzz 请求
        $client     = new Client();
        $response   = $client->request('POST', $url, [
            'json'  =>  $data,
        ]);
        $content    = $response->getBody()->getContents();

        return json_decode($content, true);
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-02
     * @copyright [copyright]
     * @license   [license]
     * @version   [代付查询]
     * @return    [type]      [description]
     */
    public function payQuery()
    {
        if($this->adminSetting->payment_type == "1")
        {
            $this->agentId = "49030624";
            $this->chanKey = "490306242EC25E03";        
        }
        // 商户余额查询地址
        $url = "/api/acq-channel-gateway/v1/wallet-manager/wallets/agents/account/payment/query";
        // 获取到token
        $token = $this->getToken('2052');
        // 代理商商户号
        $postData['agentId'] = $this->agentId;

        $postData['token']   = $token->data->token;

        $postData['traceNo'] = $this->withdraw->order_no;

        $res = $this->send($postData, $url);

        return $res;
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-02
     * @copyright [copyright]
     * @license   [license]
     * @version   [3DES 加密]
     * @param     [type]      $data [description]
     * @return    [type]            [description]
     */
    public function des3($param)
    {   
        //dd(strlen('fa48704071349482869d628880d0d5641791c9414b22a358'));
        $key = hex2bin($this->chanKey);//str_pad($this->chanKey, 8, '0');

        $size = openssl_cipher_iv_length("DES-EDE3-CBC");

        $param = $this->pkcs5_pad($param, $size);

        // $rs = openssl_encrypt($param, "DES-EDE3-ECB", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, null);
        $rs = openssl_encrypt($param, "DES-EDE3", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, null);

        $rs = bin2hex($rs);

        return $rs;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-02
     * @copyright [copyright]
     * @license   [license]
     * @version   [pkcs5_pad 填充]
     * @param     [type]      $text      [description]
     * @param     [type]      $blocksize [description]
     * @return    [type]                 [description]
     */
    function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
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
        $data = json_decode($data);

        if(gettype($data) != "object"){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅捷代付出错: 返回非对象类型!" ));
            $this->withdraw->save();
            throw new \Exception(" 畅捷代付出错: 返回非对象类型!");
        } 

        if(!$data->code){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅捷代付出错: 返回非标识码!" ));
            $this->withdraw->save();
            throw new \Exception(" 畅捷代付出错: 返回非标识码!");
        } 
        //echo json_encode($postData).$this->chanKey."<br/>";
        if($data->code != "00" && $data->code != "20" ){
            $this->withdraw->api_return_data = json_encode(array('code' => '10090', 'message' => "畅捷代付出错: ".$data->message ));
            $this->withdraw->save();
            throw new \Exception(" 畅捷代付出错:".$data->message);
        }
        # 
        return $data;
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
