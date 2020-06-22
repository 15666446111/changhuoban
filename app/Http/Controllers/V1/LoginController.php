<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{	
	/**
	 * @version  [<用户登录API接口>]
	 * @author Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function login(LoginRequest $request)
    {
    	try{

    		$User = \App\User::where('account', $request->account)->first();
    		
            if($User->password !=  "###".md5(md5($request->password. 'v3ZF87bMUC5MK570QH'))) 
                return response()->json(['error'=>['message' => '账号密码错误']]);

            if($User->active < 1) 
                return response()->json(['error'=>['message' => '用户访问受限']]); 

            $User->last_ip  =   $request->getClientIp();

            $User->last_time=   Carbon::now();

            // $User->api_token=   hash('sha256', Str::random(84));

            $User->save();

    		return response()->json(['success'=>['token' => $User->api_token]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']], 500);

        }
    }

    /**
     * 修改个人登录密码
     */
    public function editUser()
    {
        try{

            $User = \App\Buser::where('id', $request->user->id)->first();
            
            if($User->password !=  md5($request->password)) 
                return response()->json(['error'=>['message' => '账号密码错误']]);

            $User->password = \md5($request->newPassword);

            $data = $User->save();

            if($data){

                return response()->json(['success'=>['message' => '修改成功!', []]]); 

            }

        } catch (\Exception $e){

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
