<?php

namespace App\Http\Controllers\V1;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashsController extends Controller
{
    
     /**
     * 收益页面接口
     * 
     */
    public function cashsIndex(Request $request)
    {
        try{

            $type = $request->type ?? 'all';

            //总收益
            $data['revenueAll'] = $request->user->cash->sum('cash_money');
            
            //今日收益
            $data['revenueDay'] = \App\Cash::where('user_id', $request->user->id)->whereDate('created_at', Carbon::today())->sum('cash_money');
            
            //本月收益
            $data['revenueMonth'] = \App\Cash::where('user_id', $request->user->id)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('cash_money');

            // 查询用户账号余额
            $data['balance'] = $request->user->wallets->cash_blance + $request->user->wallets->return_blance;
            
            // 
            $list = \App\Cash::where('user_id', $request->user->id);
            // 收益类型
            if($type == 'cash'){
                $list->whereIn('cash_type', ['1', '2']);
            }

            if($type == 'return'){
                $list->whereIn('cash_type', ['3','4','5', '6', '7', '8']);
            }


            if($type == 'other'){
                $list->whereIn('cash_type', ['10']);
            }        
            
            $list = $list->groupBy('date')->orderBy('date', 'desc')->get(
                        array(
                            DB::raw('Date(created_at) as date'),
                            DB::raw('SUM(cash_money) as money')
                        )
                    );

            $weekarray=array("日","一","二","三","四","五","六");
            
            foreach ($list as $key => $value) {

                $dt = Carbon::parse($value->date);
                
                //dd(\App\Cash::where('user_id', $request->user->id)->whereDay('created_at', $value->date)->orderBy('created_at', 'desc')->get());
                $listdata = \App\Cash::where('user_id', $request->user->id)->whereDate('created_at', $value->date);

                if($type == 'cash'){
                    $listdata->whereIn('cash_type', ['1', '2']);
                }
    
                if($type == 'return'){
                    $listdata->whereIn('cash_type', ['3','4','5', '6', '7', '8']);
                }
    
                if($type == 'other'){
                    $listdata->whereIn('cash_type', ['10']);
                }        
                
                $listdata = $listdata->orderBy('created_at', 'desc')->get();

                $arrs = [];
                foreach ($listdata as $k => $v) {
                    
                    $arrs[] = [
                        'id'    =>$v->id,
                        'type'  => $v->type, 
                        'money' => $v->money, 
                        'sn'    => $v->trades->sn, 
                        'orderMoney' => $v->trades->amount,
                        'date'  => $v->created_at->toDateTimeString(),
                    ];
                }
                
                $data['cash'][] = array(
                    'title' => $dt->year."年".$dt->month."月".$dt->day."日", 
                    'money' => $value->money, 
                    'week'  => "星期".$weekarray[$dt->dayOfWeek],
                    'list'  => $arrs,
                );  
            }
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
