<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{


	/**
	 * [$type 查询的类型 查询本人还是代理的 区别 本人的显示自己与所有代理。代理的只显示代理名下]
	 * @var [type]
	 */
	protected $type;

	/**
	 * [$begin 查询的开始时间]
	 * @var [type]
	 */
	protected $begin;


	/**
	 * [$end 查询的结束日期]
	 * @var [type]
	 */
	protected $end;


	/**
	 * [$dateType 日期类型]
	 * @var [type]
	 */
	protected $dateType;


	/**
	 * [$date 查询的时间。格式为 2020-07]
	 * @var [type]
	 */
	protected $date;


    public function TradeDetail(Request $request)
    {
    	try {
    		$this->type = (!$request->type or $request->type =='self') ? 'self' : 'agent';

	    	// 如果查询的类型为agent 代表要查询直接下级的信息 所以agent_id 不能为空
	    	if($this->type == 'agent'){
	    		if(!$request->agent_id){
	    			return response()->json(['error'=>['message' => '缺少代理信息!']]);
	    		}
	    	}

	    	$this->dateType = (!$request->dateType or $request->dateType == 'day') ? 'day' : 'month';


	    	if($this->dateType == 'day'){
				$this->begin = Carbon::today()->toDateTimeString();
				$this->end   = Carbon::tomorrow()->toDateTimeString();
	    	}

	    	if($this->dateType == 'month'){
	    		if($request->date){
	    			$this->begin = Carbon::createFromFormat('Y-m', $request->date)->firstOfMonth()->toDateTimeString();
	    			$this->end 	 = Carbon::createFromFormat('Y-m', $request->date)->addMonth(1)->firstOfMonth()->toDateTimeString();
	    		}else{
	    			$this->begin = Carbon::now()->firstOfMonth()->toDateTimeString();
	    			$this->end 	 = Carbon::now()->addMonth(1)->firstOfMonth()->toDateTimeString();
	    		}
	    	}

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
    

    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 团队 - 业务详情 - 激活数据 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function AgentActive(Request $request)
    {
    	try{
	    	$this->type = (!$request->type or $request->type =='self') ? 'self' : 'agent';

	    	// 如果查询的类型为agent 代表要查询直接下级的信息 所以agent_id 不能为空
	    	if($this->type == 'agent'){
	    		if(!$request->agent_id){
	    			return response()->json(['error'=>['message' => '缺少代理信息!']]);
	    		}
	    	}

	    	$this->dateType = (!$request->dateType or $request->dateType == 'day') ? 'day' : 'month';

	    	if($this->dateType == 'day'){
    			$this->begin = Carbon::today()->toDateTimeString();
    			$this->end   = Carbon::tomorrow()->toDateTimeString();
	    	}

	    	if($this->dateType == 'month'){
	    		if($request->date){
	    			$this->begin = Carbon::createFromFormat('Y-m', $request->date)->firstOfMonth()->toDateTimeString();
	    			$this->end 	 = Carbon::createFromFormat('Y-m', $request->date)->addMonth(1)->firstOfMonth()->toDateTimeString();
	    		}else{
	    			$this->begin = Carbon::now()->firstOfMonth()->toDateTimeString();
	    			$this->end 	 = Carbon::now()->addMonth(1)->firstOfMonth()->toDateTimeString();
	    		}
	    	}

	    	$data = array();

	    	if($this->type == 'self'){
	    		$selfData = \App\Policy::withCount(['merchants' => function($query) use ($request) {
	    			$query->where('user_id', $request->user->id)->where('active_status', 1)->where('active_time', '>=', $this->begin)->where('active_time', '<=', $this->end);
	    		}])->get();
	    		
	    		foreach ($selfData as $key => $value) {
	    			$data['self'][]	=  array('title' => $value->title, 'count' => $value->merchants_count);
	    		}

	    		// 获取所有代理的
	    		$agent = $this->getAgent($request->user->id);
	    		$agentData = \App\Policy::withCount(['merchants' => function($query) use ($agent) {
	    			$query->whereIn('user_id', $agent)->where('active_status', 1)->where('active_time', '>=', $this->begin)->where('active_time', '<=', $this->end);
	    		}])->get();
	    		foreach ($agentData as $key => $value) {
	    			$data['agent'][]	=  array('title' => $value->title, 'count' => $value->merchants_count);
	    		}
	    	}

	    	if($this->type == 'agent'){

	    		$agentInfo = \App\Buser::where('id', $request->agent_id)->first();

	    		if(!$agentInfo or empty($agentInfo) or $agentInfo->parent != $request->user->id){
	    			return response()->json(['error'=>['message' => '无此代理信息!']]);
	    		}

	    		$agent = $this->getAgent($request->agent_id);
	    		$agent[] = $request->agent_id;
	    		// 获取所有代理的
	    		$agent = $this->getAgent($request->user->id);
	    		$agentData = \App\Policy::withCount(['merchants' => function($query) use ($agent) {
	    			$query->whereIn('user_id', $agent)->where('active_status', 1)->where('active_time', '>=', $this->begin)->where('active_time', '<=', $this->end);
	    		}])->get();
	    		foreach ($agentData as $key => $value) {
	    			$data['agent'][]	=  array('title' => $value->title, 'count' => $value->merchants_count);
	    		}
	    	}

	    	return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
