<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    /**
     * 查询用户未绑定终端机器
     */
    public function getUnBound(Request $request)
    {

        try{
            if(!$request->policy_id)  
                return response()->json(['error'=>['message' => '请选择政策活动!']]);

            //获取该用户该政策下未绑定未激活终端机器
            $list = \App\Machine::select('id','sn as merchant_sn')
            ->where('user_id',  '=', $request->user->id)
            ->where('policy_id','=', $request->policy_id)
            ->where('open_state','!=', 1)
            ->where('bind_status','!=', 1)
            ->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$list]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,请联系客服']]);

        }

    }
    

    /**
     * 划拨
     */
    public function transfer(Request $request)
    {

        try{

            $merchants=\App\Machine::whereIn('id',$request->id)->get();
            
            foreach($merchants as $k=>$v){
                
                \App\Machine::where('id',$v->id)->where('user_id',$request->user->id)->update(['user_id'=>$request->friend_id]);

            }

            foreach($request->id as $k=>$v){
                \App\Transfer::create([
                    'machine_id'    =>  $v,
                    'old_user_id'   =>  $request->user->id,
                    'new_user_id'   =>  $request->friend_id,
                    'state'         =>  $request->state
                ]);
            }

            return response()->json(['success'=>['message' => '划拨成功!', 'data'=>[]]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }


    }


    /**
     * 回拨机器列表
     */
    public function backList(Request $request)
    {

        try{

            $list = \App\Transfer::where('old_user_id',$request->user->id)
            ->where('new_user_id',$request->friend_id)
            ->where('is_back',0)
            ->where('state',1)
            ->pluck('machine_id')
            ->toArray();

            $data = \App\Machine::select('id','sn as merchant_sn')
            ->whereIn('id',$list)
            ->where('policy_id',$request->policy_id)
            ->where('open_state',0)
            ->where('bind_status',0)
            ->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * 回拨
     */
    public function backTransfer(Request $request)
    {

        try{
            dd($request->merchant_id);
            \App\Machine::where('user_id',$request->friend_id)
            ->whereIn('id',$request->merchant_id)
            ->update(['user_id'=>$request->user->id]);
            

            \App\Transfer::where('old_user_id',$request->user->id)
            ->where('new_user_id',$request->friend_id)
            ->whereIn('machine_id',$request->merchant_id)
            ->update(['is_back'=>1]);

            foreach($request->merchant_id as $k=>$v){
                $data = \App\Transfer::create([
                    'machine_id'    =>  $v,
                    'old_user_id'   =>  $request->user->id,
                    'new_user_id'   =>  $request->friend_id,
                    'state'         =>  $request->state
                ]);
            }

            

            return response()->json(['success'=>['message' => '回拨成功!', 'data'=>[]]]);

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }

    }

    /**
     * 划拨回拨记录
     */
    public function transferLog(Request $request)
    {
        try{

            $data = \App\Transfer::orderBy('created_at','desc')->get();

            $arrs = [];

            foreach($data as $k=>$v){
                
                $arrs[] = [
                    'old_user_id'   =>  $v->old_user_id,
                    'nickname'      =>  $v->old_user->nickname,
                    'merchant_sn'   =>  $v->machine->sn,
                    'state'         =>  $v->state,
                    'friend_id'     =>  $v->new_user_id,
                    'friend_name'   =>  $v->new_user->nickname
                ];

            }
            
            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }
    }
}
