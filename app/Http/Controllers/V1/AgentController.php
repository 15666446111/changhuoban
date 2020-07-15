<?php

namespace App\Http\Controllers\V1;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取代理的商户分布情况。返回代理个人商户 与 代理商户情况]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getAgentDetail(Request $request)
    {
        if(!$request->uid) return response()->json(['error'=>['message' => '无效参数']]);

        $arrs = array();

        // 获取代理
        $team = \App\UserRelation::where('parents', 'like', '%\_'.$request->uid.'\_%')->pluck('user_id')->toArray();

        $arrs['agent']  = !empty($team) ? \App\Merchant::whereIn('user_id', $team)->count() : 0;

        // 获取个人商户情况
        $arrs['me'] = \App\Merchant::where('user_id', $request->uid)->count();

        return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);

    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取某个代理的团队发展情况]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getAgentTeamDetail(Request $request)
    {
        if(!$request->uid) return response()->json(['error'=>['message' => '无效参数']]);

        $arrs = array();

        $arrs['me'] = \App\User::where('parent', $request->uid)->count();

        $arrs['agent'] = \App\UserRelation::where('parents', 'like', '%\_'.$request->uid.'\_%')->count() - $arrs['me'];

        return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取团队及代理的机器数量情况]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getAgentTemail(Request $request)
    {
    	if(!$request->uid) return response()->json(['error'=>['message' => '无效参数']]);

    	$arrs = array();

    	// 获取所有政策列表
    	$policy = \App\Policy::get();

    	$team = \App\UserRelation::where('parents', 'like', '%\_'.$request->uid.'\_%')->pluck('user_id')->toArray();

    	//
    	foreach ($policy as $key => $value) 
    	{
    		$me  	= \App\Machine::where('user_id', $request->uid)->where('policy_id', $value->id)->count();

            $agent = 0;

            if (!empty($team)) {

                $agent = \App\Machine::whereIn('user_id', $team)->where('policy_id', $value->id)->count();

            }
            

    		$arrs[] = array('title' => $value->title, 'me' => $me, 'agent' => $agent);
    	}

    	return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取团队及代理的激活]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getAgentActive(Request $request)
    {
    	if(!$request->uid) return response()->json(['error'=>['message' => '无效参数']]);

    	$arrs = array();

    	// 获取所有正常列表
    	$policy = \App\Policy::get();

    	$team = \App\UserRelation::where('parents', 'like', '%\_'.$request->uid.'\_%')->pluck('user_id')->toArray();

    	//
    	foreach ($policy as $key => $value) 
    	{
    		$me  	= \App\Merchant::where('user_id', $request->uid)->where('policy_id', $value->id)->where('active_status', 1)->count();

            $agent = 0;

            if (!empty($team)) {

                $agent  = \App\Merchant::whereIn('user_id', $team)->where('policy_id', $value->id)->where('active_status', 1)->count();

            }
    		
    		$arrs[] = array('title' => $value->title, 'me' => $me, 'agent' => $agent);
    	}

    	return response()->json(['success'=>['message' => '获取成功!', 'data'=>$arrs]]);
    }

}
