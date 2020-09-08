<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    
	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-18
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 代理和用户申请提现 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function apply(Request $request)
    {

        try{ 
            
        	if(!$request->bank_id){
        		return response()->json(['error'=>['message' => '请选择您的银行卡']]);
        	}

            $bank = \App\Bank::where('id', $request->bank_id)->where('user_id', $request->user->id)->first();

            if(!$bank or empty($bank)){
            	return response()->json(['error'=>['message' => '银行卡信息不正确']]);
            }

            if(empty($request->operate) or empty($request->operate_setting)){
            	return response()->json(['error'=>['message' => '机构未设置提现配置'],'code'=>201]);
            }

            if(!$request->operate_setting->withdraw_open){
                return response()->json(['error'=>['message' => '机构未开启提现功能!'],'code'=>201]);
            }

            if(!$request->blance){
            	return response()->json(['error'=>['message' => '请选择您的提现钱包']]);
            } 

            if(!$request->money){
				 return response()->json(['error'=>['message' => '请输入您的提现金额']]);            	
            }

            if(!$request->user->phone){
            	 return response()->json(['error'=>['message' => '请设置您的预留手机号']]);
            }

            if(!$request->user->draw_state){
                 return response()->json(['error'=>['message' => '您的账户已冻结,请联系您的上级代理商']]);
            }

            // 1 是分润钱包提现。2是返现钱包提现
            if($request->blance == '1'){

                $rate 		= $request->operate_setting->rate;
                
                $rate_m 	= $request->operate_setting->rate_m;

                $no_check 	= $request->operate_setting->no_check;

                $money 		= $request->user->wallets->cash_blance;

                if($request->money < ($request->operate_setting->cash_min / 100) ){
                    return response()->json(['error'=>['message' => '分润钱包最低提现'.number_format($request->operate_setting->cash_min / 100, 2, '.', ',').'元']]);
                }

            }else{

                $rate 		= $request->operate_setting->return_blance;

                $rate_m 	= $request->operate_setting->return_money;

                $no_check 	= $request->operate_setting->no_check_return;

                $money 		= $request->user->wallets->return_blance;

                if($request->money < ($request->operate_setting->return_min / 100) ){
                    return response()->json(['error'=>['message' => '返现钱包最低提现'.number_format($request->operate_setting->return_min / 100, 2, '.', ',').'元']]);
                }
            }
           
            // 
            if( $rate === null ){
            	return response()->json(['error'=>['message' => '机构未配置提现费率!']]);
            }

            // if( $rate_m === null or $rate_m == ""){
            // 	return response()->json(['error'=>['message' => '机构未配置单笔提现费']]);
            // }

            if( $money < $request->money){
            	return response()->json(['error'=>['message' => '钱包可提现余额不足']]);
            }

            // 提现限制在早9点到晚11点
            $Hour = Carbon::now()->hour;
            if($Hour < 9 || $Hour >= 23){
            	return response()->json(['error'=>['message' => '提现需在早9点到晚11点之间']]);
            }


            //判断钱包类型
            if($request->blance =='1'){

                $request->user->wallets->cash_blance   = ($request->user->wallets->cash_blance - $request->money) * 100;

            }else{
          
                $request->user->wallets->return_blance = ($request->user->wallets->return_blance - $request->money) * 100;
            
            }

            $request->user->wallets->save();

            $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

            $order_no = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
                
            \App\Withdraw::create([
                'user_id'   => $request->user->id,
                'order_no'  => $order_no,
                'money'     => $request->money * 100,
                'type'      => $request->blance,
                'real_money'=> $request->money * 100 * ( 1 - $rate / 100 ) - $rate_m,
                'rate'      => $rate,
                'rate_m'    => $rate_m,
                'make_state'=> 0,
                'pay_type'	=> ($no_check >= ($request->money * 100)) ? 2 : 1,
                'operate'   => $request->user->operate
            ]);

            \App\WithdrawsData::create([
                'order_no'  => $order_no,
                'phone'     => $request->user->phone,
                'username'  => $bank->user_name,
                'idcard'    => $bank->number,
                'bank'      => $bank->bank_name,
                'bank_open' => $bank->open_bank,
                'banklink'  => $bank->bank_open,
                'bank_number'=> $bank->bank
            ]);
    
            return response()->json(['success'=>['message' => '提现申请提交成功!', 'data' => $request->user->wallets]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

        }

    }




    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取提现费率信息 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function point(Request $request)
    {

        try{

            if(!$request->operate_setting or empty($request->operate_setting)){
                return response()->json(['error'=>['message' => '机构暂时没有配置提现信息']]);
            }

            // 判断是分润钱包还是返现钱包 * 获取提现税点
            if($request->type === "1"){
            	
                //税点
                $data['point']		=	$request->operate_setting->rate;

                //单笔提现费
                $data['rate_m']		=	number_format($request->operate_setting->rate_m / 100, 2, '.', ',');

                //免审核额度
                $data['min_money']	=	number_format($request->operate_setting->cash_min / 100, 2, '.', ',');

            }else{

                $data['point'] 		=	$request->operate_setting->return_blance;

                $data['rate_m']		=	number_format($request->operate_setting->return_money / 100, 2, '.', ',');

                $data['min_money']	=	number_format($request->operate_setting->return_min / 100, 2, '.', ',');
            }

            //提现范围时间
            $data['point_time']='9:00~21:00';

            return response()->json(['success'=>['message' => '获取成功!', 'data'=> $data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
