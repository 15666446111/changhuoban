<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class GetOperateSetting
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

        $request->user = $User;
        
        return $next($request);
        
    }
}
