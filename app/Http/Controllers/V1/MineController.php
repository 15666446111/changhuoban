<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MineController extends Controller
{	
	/**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 伙伴详情 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function info(Request $request)
    {
    	try{
            $userFirst = \App\User::where('id',$request->team_user)->first();
            $data = [];
            //用户id
            $data['id'] = $userFirst->id;
            //用户昵称
            $data['nickname'] = $userFirst->nickname;
            //用户账号
            $data['account'] = $userFirst->account;
            //用户状态
            $data['active'] = $userFirst->active;
            //用户头像
            $data['heading'] = $userFirst->avatar;
            //用户手机号
            $data['phone'] = $userFirst->phone;
            //用户组id
            $data['user_group'] = $userFirst->user_group;
            //用户级别
            $data['group'] = $userFirst->group->name;
            //注册时间
            $data['created_at'] = $userFirst->created_at->toDateTimeString();
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);
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
