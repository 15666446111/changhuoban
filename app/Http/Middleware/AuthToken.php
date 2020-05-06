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
        if(!$request->header('Authorization')){
            return response()->json(['error'=>['message' => '非法请求!']]);
        }
        
        if(strpos($request->header('Authorization'), "Bearer ", 0) !== 0){
            return response()->json(['error'=>['message' => '非法请求!']]);
        }

        $Bearer = Str::after($request->header('Authorization'), "Bearer ");

        $User = \App\User::where('api_token', $Bearer)->where('active', '>=', 1)->first();

        if(!$User or empty($User)) return response()->json(['error'=>['message' => '非法请求!']]);

        $request->user = $User;
        
        return $next($request);
    }
}
