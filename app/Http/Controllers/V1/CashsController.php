<?php

namespace App\Http\Controllers\V1;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashsController extends Controller
{
    
    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 收益栏目 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function cashsIndex(Request $request)
    {
        try{

            $type = $request->type ?? 'all';

            //总收益
            $revenueAll = $request->user->cash->sum('cash_money');
            $data['revenueAll'] = number_format( $revenueAll / 100, 2, '.', ',');
            
            //今日收益
            $revenueDay = \App\Cash::where('user_id', $request->user->id)->whereDate('created_at', Carbon::today())->sum('cash_money');
            $data['revenueDay'] = number_format( $revenueDay / 100, 2, '.', ',');
            
            //本月收益
            $revenueMonth = \App\Cash::where('user_id', $request->user->id)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('cash_money');
            $data['revenueMonth'] = number_format( $revenueMonth / 100, 2, '.', ',');

            // 默认查询一周
            if(!$request->date){

                $request->begin = Carbon::today()->subDays(7)->toDateTimeString();

                $request->end   = Carbon::now()->toDateTimeString();

            }else{

                $date = Carbon::createFromFormat('Y-m', $request->date);

                $request->begin = $date->firstOfMonth()->toDateTimeString();

                $request->end   = $date->lastOfMonth()->toDateTimeString();
            }


            $list = \App\Cash::where('user_id', $request->user->id)->whereBetween('created_at', [$request->begin, $request->end]);

            // 收益类型
            if($type == 'cash'){
                $list->whereIn('cash_type', ['1', '2']);
            }

            if($type == 'return'){
                $list->whereIn('cash_type', ['3','4','5', '6', '7', '8', '']);
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
                $listdata = \App\Cash::where('user_id', $request->user->id)->with('trades')->whereDate('created_at', $value->date);

                if($type == 'cash'){
                    $listdata->whereIn('cash_type', ['1', '2']);
                }
    
                if($type == 'return'){
                    $listdata->whereIn('cash_type', ['3','4','5', '6', '7', '8', '9']);
                }
    
                if($type == 'other'){
                    $listdata->whereIn('cash_type', ['10']);
                }        
                
                $listdata = $listdata->orderBy('created_at', 'desc')->get();

                $arrs = [];

                foreach ($listdata as $k => $v) {
                    
                    $arrs[] = [
                        //'order'         => $v->trades->id,
                        'id'            => $v->id,
                        'type'          => $v->cash_type, 
                        'money'         => number_format($v->cash_money / 100 , 2 , '.', ','), 
                        'sn'            => $v->trades->sn ?? '冻结机器激活', 
                        'orderMoney'    => isset($v->trades->amount) ? number_format( $v->trades->amount / 100, 2, '.', ',') : '冻结机激活返现',
                        //'orderMoney'    => $v->trades->amount ? number_format( $v->trades->amount / 100, 2, '.', ',') : "0.00",
                        'date'          => $v->created_at->toDateTimeString(),
                    ];
                }
                //dd($arrs);
                $data['cash'][] = array(
                    'title' => $dt->year."年".$dt->month."月".$dt->day."日", 
                    'money' => number_format($value->money / 100, 2, '.', ','),
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
