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

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择划拨终端']]);

            if(!$request->friend_id) return response()->json(['error'=>['message' => '缺少必要参数:请选择收货人']]);

            foreach($request->id as $k=>$v){

                $re = \App\Machine::where('id', $v)->where('user_id', $request->user->id)->update(['user_id' => $request->friend_id]);

                if ($re) {
                    \App\Transfer::create([
                        'machine_id'    =>  $v,
                        'old_user_id'   =>  $request->user->id,
                        'new_user_id'   =>  $request->friend_id,
                        'state'         =>  1,
                        'operate'       =>  $request->user->operate
                    ]);
                }
            }

            return response()->json(['success'=>['message' => '划拨成功!', 'data'=>[]]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }


    }


    /**
     * 回拨机器列表
     */
    public function backList(Request $request)
    {

        try{

            if(!$request->friend_id) return response()->json(['error'=>['message' => '缺少必要参数:请选择回拨会员']]);

            if(!$request->policy_id) return response()->json(['error'=>['message' => '缺少必要参数:请选择终端活动']]);

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
            
            if(!$request->friend_id) return response()->json(['error'=>['message' => '缺少必要参数:请选择回拨会员']]);

            if(!$request->merchant_id) return response()->json(['error'=>['message' => '缺少必要参数:请选择回拨终端']]);

            $res=\App\Machine::whereIn('user_id',$request->friend_id)
            ->whereIn('id',$request->merchant_id)
            ->update(['user_id'=>$request->user->id]);

            if($res){

                $data=\App\Transfer::where('old_user_id',$request->user->id)
                ->whereIn('new_user_id',$request->friend_id)
                ->whereIn('machine_id',$request->merchant_id)
                ->update(['is_back'=>1]);

                if($data){

                    foreach($request->merchant_id as $k=>$v){

                        foreach($request->friend_id as $key=>$value){
                            $info = \App\Transfer::create([
                                'machine_id'    =>  $v,
                                'old_user_id'   =>  $request->user->id,
                                'new_user_id'   =>  $value,
                                'state'         =>  $request->state,
                                'operate'       =>  $request->user->operate
                            ]);
                        }
                        
                    }

                }
                

            }
            
            if($info){

                return response()->json(['success'=>['message' => '回拨成功!', 'data'=>[]]]);

            }

            return response()->json(['success'=>['message' => '回拨成功!', 'data'=>[]]]);

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }

    /**
     * 划拨回拨记录
     */
    public function transferLog(Request $request)
    {
        try{

            if(!$request->type){
                $request->type = 'my_transfer';
                // my_back 我的回拨
                // parent_transfer 上级划拨
                // parent_back 上级回拨
            }

            $data = \App\Transfer::where('id', '>=', 1);
            // 我的划拨
            if($request->type == 'my_transfer'){
                $data->where('old_user_id', $request->user->id)->where('state', 1);
            }

            // 我的回拨
            if($request->type == 'my_back'){
                $data->where('old_user_id', $request->user->id)->where('state', 2);
            }

            // 上级划拨
            if($request->type == 'parent_transfer'){
                $data->where('new_user_id', $request->user->id)->where('state', 1);
            }

            // 上级回拨
            if($request->type == 'parent_back'){
                $data->where('new_user_id', $request->user->id)->where('state', 2);
            }

            $list = $data->get();

            $arrs = array();

            foreach ($list as $key => $value) {
                $arrs[] = array(
                    'nickname'      =>  $value->old_user->nickname,
                    'friend_name'   =>  $value->new_user->nickname,
                    'merchant_sn'   =>  $value->machine->sn,
                    'created_at'    =>  ($request->type == 'my_back' or $request->type == 'parent_back') ? $value->updated_at->toDateTimeString() : $value->created_at->toDateTimeString()
                );
            }
            
            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);
        
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-23
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取区间可划拨列表 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function sectionPolicy(Request $request)
    {
        try {

            if (empty($request->begin_sn)) {
                return response()->json(['error'=>['message' => '缺少必要参数:请选择输入机具起始SN号']]);
            }

            if (empty($request->end_sn)) {
                return response()->json(['error'=>['message' => '缺少必要参数:请选择输入机具结束SN号']]);
            }

            if (empty($request->policy_id)) {
                return response()->json(['error'=>['message' => '缺少必要参数:活动不能为空']]);
            }

            if (!is_numeric($request->begin_sn) || !is_numeric($request->end_sn)) {
                return response()->json(['error'=>['message' => '仅支持SN为整数的机器区间划拨']]);
            }

            $data = [];

            $lenth = strlen($request->begin_sn);

            for($i = $request->begin_sn; $i<= $request->end_sn; $i++){
                $i =sprintf("%0".$lenth."d", $i);
                $data[] = $i;
            }

            $list = \App\Machine::where('user_id', $request->user->id)
                                ->where('policy_id', $request->policy_id)
                                ->whereIn('sn', $data)
                                ->where('bind_status', 0)
                                ->where('activate_state', 0)
                                ->get();
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $list]]);

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
