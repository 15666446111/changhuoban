<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{	
	/**
	 * @version [<vector>] [< 访问项目主目录 处理控制器>]
	 * @author  [Pudding] <[< 755969423@qq.com >]>
	 */
    public function index(Request $request)
    {
    	return view('login');
    }
}
