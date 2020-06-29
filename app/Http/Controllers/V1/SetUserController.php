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
            
            $data = [];
            //用户id
            $data['id'] = $request->user->id;
            //用户昵称
            $data['nickname'] = $request->user->nickname;
            //用户账号
            $data['account'] = $request->user->account;
            //用户状态
            $data['active'] = $request->user->active;
            //用户头像
            $data['heading'] = $request->user->avatar;
            //用户组id
            $data['user_group'] = $request->user->user_group;
            //用户级别
            $data['group'] = $request->user->group->name;
            //钱包总余额
            $data['blance'] = $request->user->wallets->cash_blance + $request->user->wallets->return_blance;
            //分润余额
            $data['cash_blance'] = $request->user->wallets->cash_blance;
            //返现余额
            $data['return_blance'] = $request->user->wallets->return_blance;
            //注册时间
            $data['created_at'] = $request->user->created_at;

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
        
    }

    /**
     * 修改用户头像/昵称
     */
    // public function editUserInfo(){
        // try{ 

            // $heading = $request->avatar;

            // $res = \App\User::where('user_id',$request->user->id)->save(['avatar'=>$heading]);   

            // return response()->json(['success'=>['message' => '修改成功!', []]]); 
        // } catch (\Exception $e) {
            // 
            // return response()->json(['error'=>['message' => $e->getMessage()]]);
        // }
    // }


    /**
     * 修改个人信息
     */
    public function setUserInfos(Request $request)
    {

        try{ 
            
            $userInfo = \App\User::where('id',$request->user->id)->first();

            $userInfo->nickname = $request->nickname;

            $userInfo->save();
            return response()->json(['success'=>['message' => '修改成功!', []]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

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


    /**
     * 提现税点接口
     */
    public function point(Request $request)
    {

        try{ 
            
            // 判断是分润钱包还是返现钱包 * 获取提现税点
            if($request->type == '1'){
                //税点
                $data['point']=$request->user->points->rate;
                //单笔提现费
                $data['rate_m']=$request->user->points->rate_m;
                //免审核额度
                $data['no_check']=$request->user->points->no_check;

            }else
                $data['point']=$request->user->points->return_blance;

                $data['rate_m']=$request->user->points->return_money;

                $data['no_check']=$request->user->points->no_check;
            
            //最小提现金额
            $data['min_money']=200;
            //提现范围时间
            $data['point_time']='9:00~21:00';

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }

    }


    /**
     * 用户提现接口
     */
    public function Withdrawal(Request $request)
    {
        try{ 

            // if($request->user->wallets->blance_active !="1"){
            //     return response()->json(['error'=>['message' => $request->user->wallets->blance_bak]]);
            // }

            $checkDayStr = date('Y-m-d ',time());
            $timeBegin1  = strtotime($checkDayStr."09:00".":00");
            $timeEnd1    = strtotime($checkDayStr."21:00".":00");
            
            $curr_time   = time();
            
            //判断是否在这个时间段内提现
            if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
            {

                if($request->money < 20000 ){

                    return response()->json(['error'=>['message' => '提现金额必须不低于200元']]);
    
                }
        
                //判断钱包类型
                if($request->blance =='1'){
                    
                    if($request->user->wallets->cash_blance < $request->money ){
                        return response()->json(['error'=>['message' => '当前钱包余额不足']]);
                    }

                    $request->user->wallets->cash_blance = $request->user->wallets->cash_blance - $request->money;
    
                }else{

                    if($request->user->wallets->return_blance < $request->money ){
                        return response()->json(['error'=>['message' => '当前钱包余额不足']]);
                    }

                    $request->user->wallets->return_blance = $request->user->wallets->return_blance - $request->money;
                }

                $request->user->wallets->save();
                
                
                \App\Withdraw::create([
                    'user_id'   => $request->user->id,
                    'money'     => $request->money,
                    'type'      => $request->rate,
                    'real_money'=> $request->money - $request->money * $request->rate - $request->rate_m,
                    'state'     => '1',
                    'make_state'=> '2',
                ]);
    
                return response()->json(['success'=>['message' => '提现申请提交成功!', 'data' => $request->user->wallets]]);

            }else{   
                
                return response()->json(['error'=>['message' => '请在规定时间提现哦']]);

            }


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }
}
