<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PlugController extends Controller
{	
	/**
	 * @version  [<获取轮播图接口>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function index(Request $request)
    {
    	try{
            // 获取展示的轮播图
            $Plug = \App\Plug::where('active', '1')->ApiGet()->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $Plug]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
