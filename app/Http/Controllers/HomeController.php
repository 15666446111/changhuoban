<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\XxController;


class HomeController extends Controller
{	
	/**
	 * @version [<vector>] [< 访问项目主目录 处理控制器>]
	 * @author  [Pudding] <[< 755969423@qq.com >]>
	 */
    public function index(Request $request)
    {
        // \App\User::create([
        //     'nickname'      => '测试c1',
        //     'account'       => '15666446115',
        //     'phone'         => '15666446115',
        //     'password'      => "###" . md5(md5('123456' . 'v3ZF87bMUC5MK570QH')),
        //     'user_group'    => 1,
        //     'parent'        => 9,
        //     'operate'       => 'CP1002020041714132163',
        // ]);
    	return view('login');
    }


    /**
     * [home 项目主页面]
     * @author Pudding
     * @DateTime 2020-04-17T14:29:43+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function home(Request $request)
    {
    	return view('home');
    }
}
