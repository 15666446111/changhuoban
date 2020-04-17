<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminApiController extends Controller
{	
	/**
	 * [getPlugType 获取轮播图类型列表]
	 * @author Pudding
	 * @DateTime 2020-04-16T12:23:10+0800
	 * @param    Request                  $request [description]
	 * @return   [type]                            [description]
	 */
    public function getPlugType(Request $request)
    {
    	return \App\PlugType::where('active', '1')->get(['id', 'name as text'])->toArray();
    }

    /**
     * [getShareType 获取分享类型]
     * @author Pudding
     * @DateTime 2020-04-16T13:46:50+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function getShareType(Request $request)
    {
    	return \App\ShareType::where('active', '1')->get(['id', 'name as text'])->toArray();
    }
}
