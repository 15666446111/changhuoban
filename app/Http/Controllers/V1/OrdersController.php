<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

class OrdersController extends Controller
{
     /**
     * 生成订单接口
     */
    public function orderCreate(Request $request)
    {
        try{

            if(!$request->address) return response()->json(['error'=>['message' => '缺少必要参数:收获地址']]);
            
            $address = \App\Address::where('id',$request->address)->first();
            
            if(!$address) return response()->json(['error'=>['message' => '缺少必要参数:请设置您的收货地址']]);

            if(!$request->numbers) return response()->json(['error'=>['message' => '缺少必要参数:购买数量']]);

            if(!$request->price) return response()->json(['error'=>['message' => '缺少必要参数:订单总价']]);

            if(!$request->product_id) return response()->json(['error'=>['message' => '缺少必要参数:产品']]);

            if(!$request->product_price) return response()->json(['error'=>['message' => '缺少必要参数:产品单价']]);

            if(!$request->pay_type) return response()->json(['error'=>['message' => '缺少必要参数:支付方式']]);

            $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

            $order_no = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

            $data = \App\Order::create([

                'user_id' =>$request->user->id,

                'order_no'=>$order_no,

                'address'=>'姓名:'.$address->name.'&电话:'.$address->tel.'&省'.$address->province.'&市'.$address->city.'&区'.$address->area.'&详细地址:'.$address->detail,

                'numbers' =>$request->numbers,

                'price'   =>$request->price * 100,

                'product_id'   =>$request->product_id,

                'product_price'=>$request->product_price * 100,

                'remark'  =>$request->remark ?? '',

                'operate' =>$request->user->operate
            ]); 

            if($request->pay_type == '1'){
                //支付宝支付
                Factory::setOptions($this->getOptions());
                //2. 发起API调用（以支付能力下的统一收单交易创建接口为例）

                $result = Factory::payment()->App()->pay('1', $data->order_no, $data->price);

                if($result && $result->body)
                    return response()->json(['success'=>['message' => '订单创建成功!', 'data'=> ['sign' => $result->body]]]);
                else
                    return response()->json(['error'=>['message' => '生成支付签名失败']]);

            }else{
                //微信支付
                $this->wechat_pay($data);
            }
            
        }catch (Exception $e) {
            return response()->json(['error'=>['message' => $e->getMessage()]]);
        }
    }


    /** @Author Pudding 获取支付宝配置参数 */
    public function getOptions()
    {
        $options = new Config();

        //获取当前操盘方的属支付数据
        $data = \App\AdminSetting::where("operate_number",request()->user->operate)->where("type", 1)->first();
        
        $options->protocol      = 'https';
        
        $options->gatewayHost   = 'openapi.alipay.com';

        $options->signType      = 'RSA2';

        $options->appId         = $data->alipay_id;
        
        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = $data->alipay_sec;
        // dd($options->merchantPrivateKey);
        
        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        $options->alipayPublicKey = $data->alipay_sign; 

        //可设置异步通知接收服务地址（可选）
        $options->notifyUrl = env('APP_URL').'/callback ';


        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        // $options->encryptKey = "OIWl7LvhQ2LtgDHYrw1iEA=="; 
        return $options;
    }

    /**
     * 微信支付
     */
    public function wechat_pay($data)
    {
        $user = \App\AdminSetting::where("operate_number",request()->user->operate)->where("type", 1)->first();
        //支付
        $config = [
            // 必要配置
            'app_id'             => md5('wxd678efh567hg6787'),

            'mch_id'             => '14577xxxx',

            'key'                => '12345678912345678912345678912345',   // API 密钥

            'notify_url'         => env("APP_URL").'api/V1/payments/wechat-notify',
            
        ];
        
        $app = \EasyWeChat\Factory::payment($config);

        //下单
        $result = $app->order->unify([
            'body'         => '畅伙伴-机器购买',

            'out_trade_no' => $data->order_no,

            'total_fee'    => $data->price * 100,

            'trade_type'   => 'APP', // 请对应换成你的支付方式对应的值类型

        ]);
       
        
        if( $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $result = $app->jssdk->appConfig($result['prepay_id']);//第二次签名

            return response()->json(['success'=>['message' => '订单创建成功!', 'data'=> ['sign' => $result]]]);
            
         }else{
            // 　　\EasyWeChat\Log::error('微信支付签名失败:'.var_export($result,1));
            return response()->json(['error'=>['message' => '生成支付签名失败']]);
         }

    }

    /**
     * 修改订单状态(微信)
     */
    public function paySuccess()
    {
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function ($message, $fail) {
            
            //处理订单等，业务逻辑
            $res = \App\Order::where('order_no',$order_no)->update(['status'=>1]);

        });

        return $response;
    }


    /**
     * 修改订单状态(支付宝)
     */
    public function AliPayCallback(){

        $parameters = $_POST;

        Factory::payment()->common()->verifyNotify($parameters);

        $res = \App\Order::where('order_no',$_POST['out_trade_no'])->update(['status'=>1]);

    }

    /**
     * 查询订单接口
     */
    public function  getOrder(Request $request)
    {
        try{ 
            
            $type = $request->type ?? 'all';

            $data = \App\Order::where('user_id',$request->user->id)->get();

            $arrs = [];
            
            foreach($data as $k=>$v){

                $arrs[] = [
                    'title'      =>  $v->products->title,
                    'image'      =>  $v->products->image,
                    'order_no'   =>  $v->order_no,
                    'id'         =>  $v->id,
                    'status'     =>  $v->status,
                    'price'      =>  $v->price,
                    'product_id' =>  $v->product_id,
                    'product_price'=>$v->product_price,
                    'numbers'    =>  $v->numbers
                ];

            }

            if($type == "shop"){
                
            }
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $arrs]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }

    /**
     * 物流接口
     */
    public function orderLogistics()
    {
        //参数设置
        // $post_data = array();
        // $post_data["customer"] = '*****';
        // $key= '*****' ;
        // $post_data["param"] = '{"com":"*****","num":"*****"}';

        // $url='http://poll.kuaidi100.com/poll/query.do';
        // $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        // $post_data["sign"] = strtoupper($post_data["sign"]);
        // $o="";
        // foreach ($post_data as $k=>$v)
        // {
        //     $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        // }
        // $post_data=substr($o,0,-1);
        // $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_HEADER, 0);
        //     curl_setopt($ch, CURLOPT_URL,$url);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        //     $result = curl_exec($ch);
        //     $data = str_replace("\"",'"',$result );
        //     $data = json_decode($data,true);
    }

}
