<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    /**
     * @Author    Pudding
     * @DateTime  2020-06-02
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取政策活动列表]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getPolicy(Request $request)
    {
    	try{
            
            $policy = \App\Policy::select(['id', 'title'])->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $policy]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

}
