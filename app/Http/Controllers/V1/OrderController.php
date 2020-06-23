<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
     /**
     * 生成订单接口
     */
    public function orderCreate(Request $request)
    {

        Factory::setOptions($this->getOptions());

        try {
            //2. 发起API调用（以支付能力下的统一收单交易创建接口为例）
            $result = Factory::payment()->App()->pay("iPhone6 16G", "20200326235526001", "88.88");
            dd($result->body);
            //3. 处理响应或异常
            if (!empty($result['code']) && $result['code'] == 10000) {
                echo "调用成功". PHP_EOL;
            } else {
                echo "调用失败，原因：". $result['msg']."，".$result['sub_msg'].PHP_EOL;
            }
        } catch (Exception $e) {
            echo "调用失败，". $e->getMessage(). PHP_EOL;;
        }

    }

    /**
     * 查询订单接口
     */
    public function  getOrder(Request $request)
    {

        try{ 

            $type = $request->type ?? 'all';
            
            $data=\App\Order::
            select('image','products.id','title','order_no','address','orders.price','status','numbers','products.price','products.price as good_price','orders.price as order_price')
            ->join('products','orders.product_id','=','products.id')
            ->where('orders.user_id',$request->user->id);

            if($type == "shop"){

            }

            $data = $data->get();
            
            

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误，请联系客服']]);

        }

    }

    
    /** @Author Pudding 获取支付宝配置参数 */
    public function getOptions()
    {

        $options = new Config();

        $options->protocol = 'https';

        $options->gatewayHost = 'openapi.alipay.com';

        $options->signType = 'RSA2';
        
        $options->appId = config('app.alipay_appid');
        
        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = config('app.alipay_privatekey');
        
        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';
        $options->alipayPublicKey = config('app.alipay_publickey');


        return $options;


        //可设置异步通知接收服务地址（可选）
        $options->notifyUrl = "wuka.test/nofity";
        
        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        $options->encryptKey = config('app.alipay_encyptkey');

        return $options;
    }
}
