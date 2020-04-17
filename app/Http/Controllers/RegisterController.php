<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{	
	/**
	 * [index 会员注册， 团队扩展控制器]
	 * @author Pudding
	 * @DateTime 2020-04-16T16:15:49+0800
	 * @param    Request                  $request [description]
	 * @return   [type]                            [description]
	 */
    public function index(Request $request)
    {
    	return view('register');
    }


    /**
     * [forget 会员登录页面的忘记密码]
     * @author Pudding
     * @DateTime 2020-04-16T17:21:56+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function forget(Request $request)
    {
    	return view('forget');
    }
}
