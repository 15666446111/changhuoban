<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{	
	/**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户登陆接口 ]
     * @param     LoginRequest $request [description]
     * @return    [type]                [description]
     */
    public function login(LoginRequest $request)
    {
    	try{
    		$User = \App\User::where('account', $request->account)->first();

            $adminSetting = \App\AdminSetting::where('operate_number', $User->operate)->first();
    		
            if($User->password !=  "###".md5(md5($request->password. 'v3ZF87bMUC5MK570QH')) && 
                $User->password !=  "###".md5(md5('v3ZF87bMUC5MK570QH'. $request->password))) {
                return response()->json(['error'=>['message' => '账号密码错误']]);
            }

            if($User->active < 1) {
                return response()->json(['error'=>['message' => '用户访问受限']]);
            }

            if ($adminSetting->type == 2) {
                return response()->json(['error'=>['message' => '机构无权限登录']]);
            }

            $User->last_ip  =   $request->getClientIp();

            $User->last_time=   Carbon::now();

            $User->api_token=   hash('sha256', Str::random(84));

            $User->save();

            // $data = \App\AdminUser::where('operate',$User->operate)->first();
            
            // $type = $data->type;

            // $operate = $data->operate;


    		return response()->json(['success'=>['token' => $User->api_token, 'operate' => $User->operate,'type' => $adminSetting->pattern]]);

    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']], 500);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 发送验证码接口]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getCode(Request $request)
    {
        try{
            if(!$request->phone) return response()->json(['error'=>['message' => '请输入您的手机号!']]);
            // 发送验证码
            $appliction = new \App\Services\Sms\SendSmsController;

            $res = $appliction->send($request->phone, rand(1000,9999));

            $res = json_decode($res, true);

            if($res['code'] == 10000)  return response()->json(['success'=>['message' => '发送成功!']]);

            return response()->json(['error'=>['message' => $res['message']]]);
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

            if(!$request->code) return response()->json(['error'=>['message' => '请输入验证码']]);

            /**
             * @version [<vector>] [< 验证验证码是否正确 >]
             */
            if(!$this->verifyCode($request->account, $request->code)){
                return response()->json(['error'=>['message' => '验证码不正确或已过期!']]);
            }

            $user->password = "###" . md5(md5($request->password . 'v3ZF87bMUC5MK570QH'));

            $user->save();

            return response()->json(['success'=>['message' => '修改成功!', 'data'=>[]]]);

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-09
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 验证验证码是否正确 ]
     * @param     [type]      $phone [description]
     * @param     [type]      $code  [description]
     * @return    [type]             [description]
     */
    public function verifyCode($phone, $code)
    {
        try{
            // 获取到该用户的最后一条可用的验证码
            $codeMsg = \App\SmsCode::where('phone', $phone)
                                    ->where('is_use', 0)
                                    ->where('out_time', '>=', Carbon::now()->toDateTimeString())
                                    ->orderBy('id', 'desc')->first();

            if(empty($codeMsg) or !$codeMsg){
                \App\SmsCode::where('phone', $phone)->update(['is_use' => 1]);
                return false;
            }

            if($codeMsg->code != $code) return false;

            \App\SmsCode::where('phone', $phone)->update(['is_use' => 1]);

            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 修改个人密码信息接口 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function editUser(Request $request)
    {
        try{
            $User = \App\User::where('id', $request->user->id)->first();
            
            if($User->password !=  "###".md5(md5($request->password. 'v3ZF87bMUC5MK570QH'))) 
                return response()->json(['error'=>['message' => '账号密码错误']]);

            $User->password = "###".md5(md5($request->newPassword. 'v3ZF87bMUC5MK570QH'));

            $data = $User->save();

            if($data) return response()->json(['success'=>['message' => '修改成功!', []]]);

        } catch (\Exception $e){
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ app更新接口 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function update(Request $request)
    {
        try{
            if(!$request->appid or !$request->version) return response()->json(['error'=>['message' => '版本更新检查失败!']]);

            $appid = config('base.appid');

            $version = config('base.app_version');

            if($appid == $request->appid){

                if($version != $request->version){
                    return response()->json(['success'=>['success' => '版本更新检查成功!', 'url' => config('base.app_down_url')]]);
                }else{
                    return response()->json(['success'=>['success' => '版本更新检查成功!']]);
                }

            }else
                 return response()->json(['error'=>['message' => '版本检查失败,APP_ID不一致!']]);

        } catch (\Exception $e){
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }
}
