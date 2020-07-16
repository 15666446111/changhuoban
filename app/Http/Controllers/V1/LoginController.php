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

            $User->api_token=   hash('sha256', Str::random(84));

            $User->save();

            $data = \App\AdminUser::where('operate',$User->operate)->first();

            $type = $data->type;

            $operate = $data->operate;

    		return response()->json(['success'=>['token' => $User->api_token,'operate' => $operate,'type' => $type]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']], 500);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 忘记密码接口 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function forget(Request $request)
    {

        try{

            if(!$request->account) return response()->json(['error'=>['message' => '请输入账号!']]);

            $user = \App\User::where('account',$request->account)->first();

            if(!$user or empty($user)) return response()->json(['error'=>['message' => '账号不存在!']]);

            if($request->password !== $request->password1) return response()->json(['error'=>['message' => '请保持密码一致']]);

            if($request->code !== '8888') return response()->json(['error'=>['message' => '验证码错误']]);

            $user->password = "###" . md5(md5($request->password . 'v3ZF87bMUC5MK570QH'));

            $user->save();

            return response()->json(['success'=>['message' => '修改成功!', 'data'=>[]]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * 修改个人登录密码
     */
    public function editUser(Request $request)
    {
        try{

            $User = \App\User::where('id', $request->user->id)->first();
            
            if($User->password !=  "###".md5(md5($request->password. 'v3ZF87bMUC5MK570QH'))) 
                return response()->json(['error'=>['message' => '账号密码错误']]);

            $User->password = "###".md5(md5($request->newPassword. 'v3ZF87bMUC5MK570QH'));

            $data = $User->save();

            if($data){

                return response()->json(['success'=>['message' => '修改成功!', []]]); 

            }

        } catch (\Exception $e){

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
