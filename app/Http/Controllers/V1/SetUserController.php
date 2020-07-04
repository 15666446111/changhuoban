<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
            //用户手机号
            $data['phone'] = $request->user->phone;
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
    public function editUserInfo(Request $request){

        try{
            $User = \App\User::where('id', $request->user->id)->first(); 
            
            $heading = $request->avatar;
            var_dump($request->all());
            $filename = uniqid() . '.' . $heading->getClientOriginalExtension();
            
            Storage::disk('file')->put('/'.$filename,file_get_contents($heading->getRealPath()));

            $User->avatar = "images/".$filename;

            $res = $User->save();

            if($res){

                return response()->json(['success'=>['message' => '修改成功!', []]]); 

            }

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
        
    }


    /**
     * 修改个人信息
     */
    public function setUserInfos(Request $request)
    {

        try{ 
            
            if(!$request->nickname) return response()->json(['error'=>['message' => '缺少必要参数:名称']]);
            
            $userInfo = \App\User::where('id',$request->user->id)->first();

            $userInfo->nickname = $request->nickname;

            $userInfo->save();

            return response()->json(['success'=>['message' => '修改成功!', []]]); 

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
            

            if(!$request->name) return response()->json(['error'=>['message' => '缺少必要参数:姓名']]);

            if(!$request->bank) return response()->json(['error'=>['message' => '缺少必要参数:银行卡号']]);

            if(!$request->bank_name) return response()->json(['error'=>['message' => '缺少必要参数:银行名称']]);

            if(!$request->number) return response()->json(['error'=>['message' => '缺少必要参数:身份证号']]);

            if(!$request->open_bank) return response()->json(['error'=>['message' => '缺少必要参数:开户行']]);

            if(!$request->city) return response()->json(['error'=>['message' => '缺少必要参数:市']]);

            if(!$request->province) return response()->json(['error'=>['message' => '缺少必要参数:省']]);

            $model = new BankController();

            $bank = ['bank_name'=>$request->bank_name,'city'=>$request->city,'province'=>$request->province];
            
            $banklink = $model->openBank($bank);

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
                'is_default'=>$request->is_default ?? 0,
                'bank_open' =>$banklink,
                'city'     =>$request->city,
                'province'  =>$request->province
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

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);
            
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

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);
            
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
            
            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);

            if(!$request->name) return response()->json(['error'=>['message' => '缺少必要参数:姓名']]);

            if(!$request->bank) return response()->json(['error'=>['message' => '缺少必要参数:银行卡号']]);

            if(!$request->bank_name) return response()->json(['error'=>['message' => '缺少必要参数:银行名称']]);

            if(!$request->number) return response()->json(['error'=>['message' => '缺少必要参数:身份证号']]);

            if(!$request->open_bank) return response()->json(['error'=>['message' => '缺少必要参数:开户行']]);

            if(!$request->city) return response()->json(['error'=>['message' => '缺少必要参数:市']]);

            if(!$request->province) return response()->json(['error'=>['message' => '缺少必要参数:省']]);

            $model = new BankController();

            $bank = ['bank_name'=>$request->bank_name,'city'=>$request->city,'province'=>$request->province];
            
            $banklink = $model->openBank($bank);

            $query = \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->first();

            if($request->is_default == 1){

                \App\Bank::where('user_id',$request->user->id)->update(['is_default'=>0]);

                \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->update([
                    'user_id'   =>  $request->user->id,
                    'user_name' =>  $request->name,
                    'bank_name' =>  $request->bank_name,
                    'bank'      =>  $request->bank,
                    'number'    =>  $request->number,
                    'open_bank' =>  $request->open_bank,
                    'is_default'=>  $request->is_default,
                    'bank_open' =>  $banklink,
                    'city'     =>$request->city,
                    'province'  =>$request->province
                ]);

            }else{

                \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->update([
                    'user_id'   =>  $request->user->id,
                    'user_name' =>  $request->name,
                    'bank_name' =>  $request->bank_name,
                    'bank'      =>  $request->bank,
                    'number'    =>  $request->number,
                    'open_bank' =>  $request->open_bank,
                    'is_default'=>  0,
                    'bank_open' =>  $banklink,
                    'city'     =>$request->city,
                    'province'  =>$request->province
                ]);

            }

            return response()->json(['success'=>['message' => '修改成功!', []]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '银行卡信息不正确']]);

        }
    }


    /**
     * 提现税点接口
     */
    public function point(Request $request)
    {

        try{ 

            if(!$request->user->settings){
                return response()->json(['message'=>['message' => '请设置您的提现信息'],'code'=>201]);
            }
            
            // 判断是分润钱包还是返现钱包 * 获取提现税点
            if($request->type == '1'){
                //税点
                $data['point']=$request->user->settings->rate;
                //单笔提现费
                $data['rate_m']=$request->user->settings->rate_m;
                //免审核额度
                $data['no_check']=$request->user->settings->no_check;

            }else
                $data['point']=$request->user->settings->return_blance;

                $data['rate_m']=$request->user->settings->return_money;

                $data['no_check']=$request->user->settings->no_check_return;
            
            //最小提现金额
            $data['min_money']=200;
            //提现范围时间
            $data['point_time']='9:00~21:00';

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * 用户提现接口
     */
    public function Withdrawal(Request $request)
    {
        try{ 
            
            $bank = \App\Bank::where('id',$request->bank_id)->first();
            
            $model = new BankController();

            $banklink = $model->openBank($bank);
            
            if(!$request->user->settings){
                return response()->json(['message'=>['message' => '请设置您的提现信息'],'code'=>201]);
            }

            if(!$request->money) return response()->json(['error'=>['message' => '缺少必要参数:提现金额']]);

            if(!$request->blance) return response()->json(['error'=>['message' => '缺少必要参数:提现类型']]);

            if(!$request->user->phone) return response()->json(['error'=>['message' => '请设置您的预留手机号']]);

            if(!$bank->user_name) return response()->json(['error'=>['message' => '信息不全:用户名']]);

            if(!$bank->number) return response()->json(['error'=>['message' => '信息不全:身份证号']]);

            if(!$bank->open_bank) return response()->json(['error'=>['message' => '信息不全:开户行']]);

            if(!$bank->bank) return response()->json(['error'=>['message' => '信息不全:银行卡号']]);
            
            if($request->blance == '1'){
                $rate = $request->user->settings->rate;
                $rate_m = $request->user->settings->rate_m;
                $no_check = $request->user->settings->no_check;
                $money = $request->user->wallets->cash_blance;
            }else{
                $rate = $request->user->settings->return_blance;
                $rate_m = $request->user->settings->return_money;
                $no_check = $request->user->settings->no_check_return;
                $money = $request->user->wallets->return_blance;
            }
            
            if(!$rate) return response()->json(['error'=>['message' => '税点不能为空']]);

            if(!$rate_m) return response()->json(['error'=>['message' => '单笔提现费不能为空']]);

            if(!$no_check) return response()->json(['error'=>['message' => '免审核额度不能为空']]);

            $state = '';
            
            if($no_check > $request->money){
                $state = '1';
            }

            $checkDayStr = date('Y-m-d ',time());
            $timeBegin1  = strtotime($checkDayStr."09:00".":00");
            $timeEnd1    = strtotime($checkDayStr."21:00".":00");
            
            $curr_time   = time();
            
            //判断是否在这个时间段内提现
            if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
            {

                if($request->money < 200 ){

                    return response()->json(['error'=>['message' => '提现金额必须不低于200元']]);
    
                }
        
                //判断钱包类型
                if($request->blance =='1'){
                    
                    if($request->user->wallets->cash_blance < $request->money ){
                        return response()->json(['error'=>['message' => '当前钱包余额不足']]);
                    }

                    $request->user->wallets->cash_blance = ($request->user->wallets->cash_blance - $request->money) * 100;
    
                }else{
                    
                    if($request->user->wallets->return_blance < $request->money ){
                        return response()->json(['error'=>['message' => '当前钱包余额不足']]);
                    }

                    $request->user->wallets->return_blance = ($request->user->wallets->return_blance - $request->money) * 100;
                }

                $request->user->wallets->save();

                $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
                $order_no = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

                \App\Withdraw::create([
                    'user_id'   => $request->user->id,
                    'order_no'  => $order_no,
                    'money'     => $request->money,
                    'type'      => $request->blance,
                    'real_money'=> ($money - $request->money) * ( 1 -$rate * 0.01) - $rate_m / 100,
                    'rate'      => $rate,
                    'rate_m'    => $rate_m,
                    'state'     => $state = 2 ? 2 : '1',
                    'check_at'  => $state = 2 ? Carbon::now() : 'NULL',
                    'make_state'=> $state = 2 ? 1 : '',
                    'operate'   =>  $request->user->operate
                ]);

                \App\WithdrawsData::create([
                    'order_no'  => $order_no,
                    'phone'     => $request->user->phone,
                    'username'  => $bank->user_name,
                    'idcard'    => $bank->number,
                    'bank'      => $bank->bank_name,
                    'bank_open' => $bank->open_bank,
                    'banklink'  => $banklink,
                    'bank_number'=> $bank->bank,
                    'reason'    => $request->reason
                ]);
    
                return response()->json(['success'=>['message' => '提现申请提交成功!', 'data' => $request->user->wallets]]);

            }else{   
                
                return response()->json(['error'=>['message' => '请在规定时间提现哦']]);

            }


    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }

    }

}
