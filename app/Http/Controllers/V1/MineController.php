<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MineController extends Controller
{	
	/**
	 * @version  [<我的栏位 获取个人信息>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function info(Request $request)
    {
    	try{

            return response()->json(['success'=>['message' => '获取成功!', 'data' => [
                'headimg'   =>  $request->user->headimg,
                'nickname'  =>  $request->user->nickname,
                'blance'    =>  number_format(($request->user->blance / 100), 2, '.', ','),
                'group'     =>  $request->user->groups->name,
            ]]]);

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * [draw_log  APP 获取提现信息]
     * @author Pudding
     * @DateTime 2020-04-13T08:53:57+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function draw_log(Request $request)
    {
        try{

            $limit = 15; 

            $page  = $request->page ? $request->page - 1 : 0;

            if(!is_numeric($page)){
                return response()->json(['error'=>['message' => '参数错误!']]); 
            }

            $page   = $page < 0 ? 0 : $page ;

            $page   = $page * $limit;

            $data   = \App\Withdraw::where('user_id', $request->user->id)->orderBy('id', 'desc')
                        ->offset($page)->limit($limit)->get();
                        
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
