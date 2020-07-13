<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function team(Request $request)
    {

        try{

            $result = Hashids::decode($request->route('code'));

            if(empty($result)) return response()->json(['error'=>['message' => '解密失败!']]);

            return view('register');

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * [team_in  会员注册 提交数据]
     * @author Pudding
     * @DateTime 2020-04-13T15:52:33+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function team_in(RegisterRequest $request)
    {
        try{

            $result = Hashids::decode($request->route('code'));

            if(empty($result)) return back()->withErrors(['参数无效!'])->withInput();

            /**
             * @version [<vector>] [< 验证验证码是否正确 >]
             */
            if(!$this->verifyCode($request->register_phone, $request->register_code)){
                 return back()->withErrors(['验证码不正确或已过期!'])->withInput();
            }
            
            if($request->register_password !== $request->register_confirm_password)
                return back()->withErrors(['两次密码不一致!'])->withInput();

            // 获取上级信息
            $Parent = \App\User::where('id', $result[0])->first();

            if(!$Parent or empty($Parent)) return back()->withErrors(['信息错误!'])->withInput();

            // 创建新用户
            $NewUser = \App\User::create([
                'nickname'      =>  $request->register_phone,
                'account'       =>  $request->register_phone,
                'password'      =>  "###" . md5(md5($request->register_password . 'v3ZF87bMUC5MK570QH')),
                'phone'         =>  $request->register_phone,
                'parent'        =>  $Parent->id,
                'user_group'    =>  1,
            ]);

            if(!$NewUser) return back()->withErrors(['注册失败,系统错误!'])->withInput(); 

            return view('register_success');

        } catch (\Exception $e) {

            return back()->withErrors(['注册失败,系统错误!'])->withInput(); 

        }
    }


    /**
     * Show the application dashboard.  扩展普通用户
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function extendUser(Request $request)
    {

        try{

            $result = Hashids::decode($request->route('code'));

            if(empty($result)) return response()->json(['error'=>['message' => '解密失败!']]);

            return view('register_user');

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * Show the application dashboard.  扫码 填写表单 申请机器
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function extendTemail(Request $request)
    {

        try{

            $result = Hashids::decode($request->route('code'));

            if(empty($result)) return response()->json(['error'=>['message' => '解密失败!']]);

            return view('register_temail');

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }





    /**
     * [team_in  会员注册 扩展普通用户 提交数据]
     * @author Pudding
     * @DateTime 2020-04-13T15:52:33+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function extendUserIn(RegisterRequest $request)
    {
        try{

            $result = Hashids::decode($request->route('code'));

            if(empty($result)) return back()->withErrors(['参数无效!'])->withInput();

            if($request->register_password !== $request->register_confirm_password)
                return back()->withErrors(['两次密码不一致!'])->withInput();

            // 获取上级信息
            $Parent = \App\User::where('id', $result[0])->first();

            if(!$Parent or empty($Parent)) return back()->withErrors(['信息错误!'])->withInput();

            // 创建新用户
            $NewUser = \App\User::create([
                'nickname'      =>  $request->register_phone,
                'account'       =>  $request->register_phone,
                'password'      =>  "###" . md5(md5($request->register_password . 'v3ZF87bMUC5MK570QH')),
                'phone'         =>  $request->register_phone,
                'parent'        =>  $Parent->id,
                'user_group'    =>  1,
            ]);

            if(!$NewUser) return back()->withErrors(['注册失败,系统错误!'])->withInput(); 

            return view('register_success');

        } catch (\Exception $e) {

            return back()->withErrors(['注册失败,系统错误!'])->withInput(); 

        }
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-08
     * @copyright [copyright]
     * @license   [license]
     * @version   [注册发送验证码]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function code(Request $request)
    {
        try{

            if(!$request->phone) return json_encode(array('code'=> -999, 'message' => '手机号不存在!'));

            // 发送验证码
            $appliction = new \App\Services\Sms\SendSmsController;

            $res = $appliction->send($request->phone, rand(1000,9999));

            return $res;
            
        } catch (\Exception $e) {

             return json_encode(array('code'=> -999, 'message' => '发送失败!'));

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
                                    ->where('out_time', Carbon::now()->toDateTimeString())
                                    ->orderBy('id', 'desc')->first();

            if(empty($codeMsg) or !$codeMsg){
                \App\SmsCode::where('phone', $phone)->update(['is_use' => 1]);
                return false;
            }

            if($codeMsg->code != $code){
                return false;
            }

            \App\SmsCode::where('phone', $phone)->update(['is_use' => 1]);

            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }


}
