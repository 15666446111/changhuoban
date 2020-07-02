<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;



class OrdersController extends Controller
{
     /**
     * 生成订单接口
     */
    public function orderCreate(Request $request)
    {
        try{

            $request->user;

            if(!$request->address) return response()->json(['error'=>['message' => '缺少必要参数:收获地址']]);

            if(!$request->numbers) return response()->json(['error'=>['message' => '缺少必要参数:购买数量']]);

            if(!$request->price) return response()->json(['error'=>['message' => '缺少必要参数:订单总价']]);

            if(!$request->product_id) return response()->json(['error'=>['message' => '缺少必要参数:产品']]);

            if(!$request->product_price) return response()->json(['error'=>['message' => '缺少必要参数:产品单价']]);


            $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

            $order_no = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

            $data = \App\Order::create([

                'user_id'=>$request->user->id,

                'order_no'=>$order_no,

                // 'address'=>$request->province.$request->area.$request->city.$request->detail,
                'address'=>$request->address,

                'numbers'=>$request->numbers,

                'price'=>$request->price,

                'product_id'=>$request->product_id,

                'product_price'=>$request->product_price,

                'remark'=>$request->remark ?? '',

                'operate'=>$request->user->operate
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
            }
            
        }catch (Exception $e) {
            return response()->json(['error'=>['message' => '系统错误，请联系客服']]);
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
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';
        $options->alipayPublicKey = $data->alipay_sign; 

        //可设置异步通知接收服务地址（可选）

        $options->notifyUrl = env('APP_URL').'/api/V1/updateOrderStatus';


        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        // $options->encryptKey = "OIWl7LvhQ2LtgDHYrw1iEA=="; 

        return $options;
    }

    /**
     * 修改订单状态
     */

    public function edit_orderStatus(Request $request){

        // $data = $request->all();

        // $parameters = array(
        //     "charset"    =>  $data->charset,
        //     "sign"       =>  $data->sign,
        //     "app_id"     =>  $data->data,
        //     "sign_type"  =>  $data->sign_type,
        //     // "isv_ticket" =>  "",
        //     "timestamp"  =>  $data->timestamp,
        //     "biz_content"=>  $data->biz_content,
        //     "notify_url" =>  $data->notify_url,
        //     //... ... 接收到的所有参数放入这里
        // );
        // Factory::payment()->common()->verifyNotify($parameters);

        return 111;
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
}
