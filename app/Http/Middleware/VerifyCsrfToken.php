<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        /**
         * @version [<vector>] [< 过滤助代通(畅捷方)的通知接口 ， 此接口不需要验证CSRF>]
         */
           '/trade',
           'wechat',
           '/getExp'
    ];
}
