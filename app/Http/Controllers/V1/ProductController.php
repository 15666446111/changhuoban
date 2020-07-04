<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    	/**
	 * @version  [<在线商城。获取产品类型信息>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function getType(Request $request)
    {
    	try{
            $type = \App\MachinesType::where("state",1)->orderBy("sort","desc")->get();
            
            if(empty($type) || !$type) return response()->json(['error'=>['message' => '当前没有商品哦']]);

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $type]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

     	/**
     * @version  [<在线商城。获取产厂商信息>]
    * @author   Pudding   
    * @DateTime 2020-04-08T17:17:40+0800
    * @param    Request
    * @return   [type]
    */
    public function getFactories(Request $request)
    {
        try{
            if(!$request->type) return response()->json(['success'=>['message' => '获取成功!', 'data' => \App\MachinesFactory::get()]]); 

            $factories =  \App\MachinesFactory::where('type_id', $request->type)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $factories]]);
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


     	/**
     * @version  [<在线商城。获取产品型号信息>]
    * @author   Pudding   
    * @DateTime 2020-04-08T17:17:40+0800
    * @param    Request
    * @return   [type]
    */
    public function getStyles(Request $request)
    {
        try{
            if(!$request->factoriy) return response()->json(['success'=>['message' => '获取成功!', 'data' => \App\MachinesStyle::get()]]); 
            
            $style =  \App\MachinesStyle::where('factory_id', $request->factoriy)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $style]]);
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-05-19
     * @copyright [copyright]
     * @license   [license]
     * @version   [根据型号获取产品列表]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getProduct(Request $request)
    {
    	try{

    		if(!$request->style)return response()->json(['success'=>['message' => '获取成功!', 'data' => \App\Product::where('active', '1')->where('state',1)->get()]]); 

    		$product = \App\Product::where('active', '1')->where('state',1)->where('style_id', $request->style)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $product]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-05-19
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取产品信息接口]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getProductInfo(Request $request)
    {
    	try{

    		if(!$request->product) return response()->json(['success'=>['message' => '获取成功!', 'data' => []]]);

    		$product = \App\Product::where('active', '1')->where('id', $request->product)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $product]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
