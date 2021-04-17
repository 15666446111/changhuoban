<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return response()->json(['error'=>['message' => '服务器维护，暂停运营，联系电话：15588837001', 'data' => ['disabled' => true]]]);

        if(!$request->header('Authorization')){
            return response()->json(['error'=>['message' => '非法请求!']]);
        }
        
        if(strpos($request->header('Authorization'), "Bearer ", 0) !== 0){
            return response()->json(['error'=>['message' => '非法请求!']]);
        }

        $Bearer = Str::after($request->header('Authorization'), "Bearer ");  

        $User = \App\User::where('api_token', $Bearer)->where('active', '>=', 1)->first();

        if(!$User or empty($User)) return response()->json(['error'=>['message' => '非法请求!']], 505);

        // 记录当前登陆用户实例
        $request->user = $User;
        
        // 记录用户的机构方
        $request->operate = $User->operates;

        // 记录操盘方设置表
        $request->operate_setting = $User->operates->settings;

        return $next($request);
    }
}
