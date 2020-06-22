<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SetUserController extends Controller
{
    
    /**
     * 获取用户个人信息
     */
    public function getUserInfo(Request $request)
    {
        try{

            $userInfo = \App\User::where('id',$request->user->id)->first();
        
            $data = [];
            //用户id
            $data['id'] = $userInfo->id;
            //用户昵称
            $data['nickname'] = $userInfo->nickname;
            //用户头像
            $data['heading'] = env('APP_URL') . '/' . 'storage/' .$userInfo->avatar;
            //用户组id
            $data['user_group'] = $userInfo->user_group;
            //用户级别
            $data['group'] = $userInfo->group->name;
            //钱包总余额
            $data['blance'] = $userInfo->wallets->cash_blance/100 + $userInfo->wallets->retrun_blance/100;
            //分润余额
            $data['cash_blance'] = $userInfo->wallets->cash_blance/100;
            //返现余额
            $data['return_blance'] = $userInfo->wallets->return_blance/100;

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
        
    }

    /**
     * 添加银行卡结算信息接口
     */
    public function insertBank(Request $request)
    {
        try{ 

            if($request->is_default == 1){

                \App\Bank::where('user_id',$request->user->id)->update(['is_default'=>0]);

            }
            
            \App\Bank::create([
                'user_id'=>$request->user->id,
                'user_name'=>$request->name,
                'bank_name'=>$request->bank_name,
                'bank'=>$request->bank,
                'number'=>$request->number,
                'open_bank'=>$request->open_bank,
                'is_del'=>0,
                'is_default'=>$request->is_default
            ]);

            return response()->json(['success'=>['message' => '添加成功!', []]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }
    }

    /**
     * 查询银行卡结算信息接口
     */
    public function selectBank(Request $request)
    {
        try{ 
            
            $data=\App\Bank::where('user_id',$request->user->id)->where('is_del',0)->orderBy('is_default','desc')->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 查询单个银行卡信息接口
     */
    public function bankFirst(Request $request)
    {
        try{ 
            
            $data=\App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 查询默认银行卡信息接口
     */
    public function bankDefault(Request $request)
    {
        try{ 
            
            $data=\App\Bank::where('user_id',$request->user->id)->where('is_default','1')->where('is_del',0)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * 删除银行卡结算信息接口
     */
    public function unsetBank(Request $request)
    {
        try{ 
            
            \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->update(['is_del'=>1]);

            return response()->json(['success'=>['message' => '删除成功!', []]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 修改银行卡结算信息接口
     */
    public function updateBank(Request $request)
    {
        try{ 

            $query = \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->first();
            
            $query->user_name = $request->name;
            $query->bank_name = $request->bank_name;
            $query->bank = $request->bank;
            $query->number = $request->number;

            if(empty($request->is_default) || $request->is_default == 0){

                $query->is_default = 0;
                $query->save();

            }else{

                \App\Bank::where('user_id',$request->user->id)->update(['is_default'=>0]);

                $query->is_default = 1;
                $query->save();

            }

            return response()->json(['success'=>['message' => '修改成功!', []]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }
    }
}
