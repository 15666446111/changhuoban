<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * 添加用户收货地址接口
     */
    public function address(Request $request)
    {
        try{ 

            if(!$request->name) return response()->json(['error'=>['message' => '缺少必要参数:收货人']]);
            
            if(!$request->tel) return response()->json(['error'=>['message' => '缺少必要参数:电话']]);

            if(!$request->province) return response()->json(['error'=>['message' => '缺少必要参数:省']]);

            if(!$request->city) return response()->json(['error'=>['message' => '缺少必要参数:市']]);

            if(!$request->area) return response()->json(['error'=>['message' => '缺少必要参数:区']]);

            if(!$request->detail) return response()->json(['error'=>['message' => '缺少必要参数:详细地址']]);

            if($request->is_default=='1'){
                $data=\App\Address::where('user_id',$request->user->id)->update(['is_default'=>0]);
            }
            
            $data=\App\Address::create([
                'user_id'=>$request->user->id,
                'name'=>$request->name,
                'tel'=>$request->tel,
                'province'=>$request->province,
                'city'=>$request->city,
                'area'=>$request->area,
                'detail'=>$request->detail,
                'is_default'=>$request->is_default ?? '0',  
            ]); 
            
            if($data){

                return response()->json(['success'=>['message' => '添加成功!', 'data' => []]]); 

            }

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 查询用户收货地址接口
     */
    public function getAAddress(Request $request)
    {
        try{ 
            
            $data=\App\Address::where('user_id',$request->user->id)->orderBy('is_default','desc')->get();
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 删除用户收货地址接口
     */
    public function deleteAddress(Request $request)
    {
        try{ 

            if(!$request->id) return response()->json(['error'=>['message' => '请选择收货地址']]);
            
            \App\Address::where('id',$request->id)->where('user_id',$request->user->id)->delete();
            
            return response()->json(['success'=>['message' => '删除成功!', 'data' => []]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 修改用户收货地址接口
     */
    public function updateAddress(Request $request)
    {
        try{ 
            if(!$request->id) return response()->json(['error'=>['message' => '请选择收货地址']]);

            if($request->is_default=='1'){
                $data=\App\Address::where('user_id',$request->user->id)->update(['is_default'=>0]);
            }
            
            $data=\App\Address::where('id',$request->id)->where('user_id',$request->user->id)->update([ 
                'name'=>$request->name,
                'tel'=>$request->tel,
                'province'=>$request->province,
                'city'=>$request->city,
                'area'=>$request->area,
                'detail'=>$request->detail,
                'is_default'=>$request->is_default,
            ]);
            if($data){

                return response()->json(['success'=>['message' => '修改成功!', 'data' => []]]); 

            }

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 查询单个收货地址接口
     */
    public function firstAddress(Request $request)
    {

        try{ 

            if(!$request->id) return response()->json(['error'=>['message' => '请选择收货地址']]);
            
            $data=\App\Address::where('id',$request->id)->where('user_id',$request->user->id)->first();

            if($data){

                return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]); 

            }

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * 查询默认收货地址接口
     */
    public function defaultAddress(Request $request)
    {

        try{ 
            
            $data=\App\Address::where('is_default',1)->where('user_id',$request->user->id)->first();

            if(empty($data) or !$data){

                return response()->json(['success'=>['message' => '获取成功!', 'data' => []]]); 

            }
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }
}
