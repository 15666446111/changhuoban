<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    	/**
	 * @version  [<在线商城。获取产品分类信息>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function getType(Request $request)
    {
    	try{
    		$type = \App\Brand::where('active', '1')->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $type]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-05-19
     * @copyright [copyright]
     * @license   [license]
     * @version   [根据分类获取产品列表]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getProduct(Request $request)
    {
    	try{

    		if(!$request->type)return response()->json(['success'=>['message' => '获取成功!', 'data' => \App\Product::where('active', '1')->where('state',1)->get()]]); 

    		$prduct = \App\Product::where('active', '1')->where('state',1)->where('type', $request->type)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $prduct]]);

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

    		$prduct = \App\Product::where('active', '1')->where('id', $request->product)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $prduct]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
