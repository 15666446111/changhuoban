<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Services\Pmpos\PmposController;

class MerchantController extends Controller
{
    
	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-28
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 商户登记 - 获取未绑定列表 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function getNoBindList(Request $request)
    {
    	try{
            $merchant = \App\Machine::select('sn as merchant_sn')->where('user_id', $request->user->id)->where('bind_status', '0')->get();
            				
           	return response()->json(['success'=>['message' => '获取成功!', 'data' => $merchant]]);
    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-06
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 商户登记 - 提交登记资料 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function registers(Request $request)
    {
        try{ 
			if(!$request->merchant_sn) return response()->json(['error'=>['message' => '缺少必要参数:终端号']]);
            if(!$request->merchant_name) return response()->json(['error'=>['message' => '缺少必要参数:商户名称']]);
            if(!$request->merchant_phone) return response()->json(['error'=>['message' => '缺少必要参数:商户电话']]);
			$data = \App\Machine::where('user_id',$request->user->id)->where('sn',$request->merchant_sn)->first();
			if(!$data or empty( $data )) return response()->json(['error'=>['message' => '找不到机器!']]);
			$result = \App\Merchant::create([
				'user_id'	=>	$data->user_id,
				'code'		=>	-1,
				'name'		=>	$request->merchant_name,
				'phone'		=>  $request->merchant_phone,
				'operate'	=>	$data->operate
			]);
			$data->merchant_id = $result->id;
			$data->bind_status = 1;
			$data->bind_time = Carbon::now()->toDateTimeString();
			$data->save();
            return response()->json(['success'=>['message' => '登记成功!', []]]); 
    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,请联系客服']]);
        }
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-06
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 商户管理 - 商户列表 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function merchantsList(Request $request)
    {
        try{ 
			$data = \App\Merchant::where('user_id',$request->user->id)->get();
			
			$arrs = [];

			if(!$data or empty($data)){ 
				$arrs['Bound'] = array();
			}else{

				foreach($data as $key=>$value){
					$sn = $value->machines->pluck('sn')->toArray();
					$sn = implode('|', $sn);
					$arrs['Bound'][] = array(
						'id'				=>		$value->id,
						'merchant_name'		=>		$value->name,
						'machine_phone'		=>		$value->phone,
						'merchant_sn'		=>		$sn,
						'money'				=>		number_format($value->trades->sum('amount') / 100, 2, '.', ','),
						'merchant_number'	=>		$value->code,
						'bind_time'			=>		$value->created_at->toDateTimeString()
					);
				}
			}
			$arrs['UnBound'] = array();
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $arrs]]); 
   		} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }
	

	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-06
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 商户管理 - 商户详情 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function merchantInfo(Request $request)
    {
        try{ 
            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择终端']]);
            $data=\App\Merchant::where('user_id',$request->user->id)->where('id',$request->id)->first();
            if(!$data or empty($data)) return response()->json(['error'=>['message' => '没有找到该机器!']]);
			$arrs = array(
				'id'					=>	$data->id,
				'merchant_name'			=>	$data->name,
				'merchant_phone'		=>	$data->phone,
				'merchant_sn'			=>	$data->machines->first()->sn,
				'merchant_code'			=>	$data->code,
				'active_status'			=>	$data->activate_sn,
				'time'					=>	$data->created_at->toDateTimeString(),
			);
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $arrs]]);   
    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
	}

	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-06
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 商户管理 - 交易明细 ]
	 * @param     Request     $request [description]
	 */
    public function MerchantDetails(Request $request)
    {
        try{ 
            if(!$request->merchant) return response()->json(['error'=>['message' => '缺少必要参数:商户号']]);
            $merchant = \App\Merchant::where('id', $request->merchant)->first();
            if(!$merchant or empty($merchant)) return response()->json(['error'=>['message' => '该商户不存在！']]);

            switch ($request->data_type) {
                case 'month':
                    $StartTime = Carbon::now()->startOfMonth()->toDateTimeString();
                    break;
                case 'day':
                    $StartTime = Carbon::today()->toDateTimeString();
                    break;
                case 'count':
                    $StartTime = Carbon::createFromFormat('Y-m-d H', '1970-01-01 00')->toDateTimeString();
                    break;
                default:
                    $StartTime = Carbon::today()->toDateTimeString();
                    break;
            }
            $EndTime = Carbon::now()->toDateTimeString();
            $data = \App\Trade::select('card_type', 'sn as merchant_sn','amount as money','trade_time')
            			->where('merchant_code', $merchant->code)->whereBetween('trade_time', [$StartTime,  $EndTime])
            			->orderBy('trade_time', 'desc')
						->get();
			if($data->isEmpty()) $data = array();
            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]);
        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误，请联系客服']]);
        }
    }


	
	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-28
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 首页 - 机具管理 - 机具统计信息 ]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
	public function getBind(Request $request)
	{
		try{
			//获取用户的伙伴
			$userAll = \App\UserRelation::where('parents', 'like', "%\_".$request->user->id."\_%")->pluck('user_id')->toArray();
			$data=[];
			if(!$userAll){
				$data['friend']['all'] = 0;
				$data['friend']['NoMerchant'] =0;
				$data['friend']['Merchant'] =0;
				$data['friend']['Merchant_status'] = 0;
				$data['friend']['standard_statis'] =0;
			}else{
				//获取伙伴机器总数
				$data['friend']['all'] = \App\Machine::whereIn('user_id', $userAll)->count();
				//获取伙伴未绑定机器总数
				$data['friend']['NoMerchant'] = \App\Machine::whereIn('user_id', $userAll)->where('bind_status', '0')->count();
				//查询伙伴已绑定机器总数
				$data['friend']['Merchant'] = \App\Machine::whereIn('user_id', $userAll)->where('bind_status', '1')->count();
				//查询伙伴已激活机器总数
				$data['friend']['Merchant_status'] = \App\Machine::whereIn('user_id', $userAll)->where('activate_state', '1')->count();
				//查询伙伴已达标机器总数
				$data['friend']['standard_statis'] = \App\Machine::whereIn('user_id', $userAll)->where('standard_status', '1')->count();
			}
			
			//获取用户机器总数
			$data['user']['all'] = \App\Machine::where('user_id', $request->user->id)->count();
			//获取用户未绑定机器总数
			$data['user']['NoMerchant'] = \App\Machine::where('user_id', $request->user->id)->where('bind_status', '0')->count();
			//查询用户已绑定机器总数
			$data['user']['Merchant'] = \App\Machine::where('user_id', $request->user->id)->where('bind_status', '1')->count();
			//查询用户已激活机器总数
			$data['user']['Merchant_status'] = \App\Machine::where('user_id', $request->user->id)->where('activate_state', '1')->count();
			//查询用户已达标机器总数
			$data['user']['standard_statis'] = \App\Machine::where('user_id', $request->user->id)->where('standard_status', '1')->count();
			
			//获取全部机器总数
			$data['count']['all']=$data['friend']['all']+$data['user']['all'];
			//获取用户未绑定机器总数
			$data['count']['NoMerchant']=$data['friend']['NoMerchant']+$data['user']['NoMerchant'];
			//查询用户已绑定机器总数
			$data['count']['Merchant']=$data['friend']['Merchant']+$data['user']['Merchant'];
			//查询伙伴已激活机器总数
			$data['count']['Merchant_status']=$data['friend']['Merchant_status']+$data['user']['Merchant_status'];
			//查询用户已达标机器总数
			$data['count']['standard_statis']=$data['friend']['standard_statis']+$data['user']['standard_statis'];

           	return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);
    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
		}
    }
    

    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 机具管理 - 机具详情 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getMerchantsTail(Request $request)
    {
        try{
            //参数 friends伙伴  count总  user用户
			$Type = $request->Type;
			
            if(!$Type) return response()->json(['error'=>['message' => '缺少必要参数:详情类型']]);

            $server = new \App\Http\Controllers\V1\ServersController($Type, $request->user);
            $data = $server->getInfo();
            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 
        } catch (\Exception $e) {
			return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
		}
	}
	

	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-07
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [获取机器的活动详情]
	 * @param     Request     $request [description]
	 * @return    [type]               [description]
	 */
    public function getActiveDetail(Request $request)
    {	
    	/**
    	 * @var 返回该机器的活动情况
    	 */
    	if(!$request->terminal ) return response()->json(['error'=>['message' => '缺少机器终端']]);

    	$ActiveInfo = array();

    	$countTradeMoney =  \App\Trade::where('sn', $request->terminal )->sum('amount');
    	
    	// 获得该机器总交易额
    	$ActiveInfo['countTradeMoney'] =number_format($countTradeMoney / 100, 2, '.', ',');


    	$ActiveInfo['tips'] = "达标统计的是T0、T1、云闪付贷记卡交易之和，非总交易额";
    	

    	return response()->json(['success'=>['message' => '获取成功', 'data' =>$ActiveInfo ]]);

	}

	/**
	 * [获取商户费率]
	 * @param Request $request [description]
	 */
	public function MerchantsRate(Request $request)
	{
		try{
            
			$merInfo = \App\Merchant::where('code', $request->code)->first();
			if ($merInfo->user_id != $request->user->id) {
				return response()->json(['error'=>['message' => '商户信息有误，请重试']]);
			}

			// 活动组id
			$policyGroupId = 0;

			// 检查商户活动组信息
			$policyGroupArr = [];
			$machines = \App\Machine::where('merchant_id', $merInfo->id)->get();

			foreach ($machines as $k => $v) {
				$policyGroupArr[$v->policys->policy_group_id] = $v->policys->policy_group_id;
				$policyGroupId = $v->policys->policy_group_id;
			}

			if (count($policyGroupArr) != 1) {
				return response()->json(['error'=>['message' => '商户活动组信息有误，请联系客服']]);
			}

			// 实例化3.0接口类
			$pmpos = new PmposController($request->code, '');

			// 查询商户费率
			$rateData = json_decode( $pmpos->getMerchantFee() );

			if ($rateData->code !== '00') {
				return response()->json(['error'=>['message' => $rateData->message]]);
			}

			$groupRate = \App\PolicyGroupRate::where('policy_group_id', $policyGroupId)
							->where('is_abjustable', 1)->get();

			$data = [
				'policy_group_id'	=> $policyGroupId,
				'rateList'			=> []
			];
			foreach ($groupRate as $k => $v) {
				
				foreach ($rateData->data as $rateKey => $rateVal) {
					
					if ($rateKey == $v->rate_types->type) {
						$data['rateList'][] = [
							'index'				=> $v->rate_type_id,
							'title'				=> $v->rate_types->type_name,
							'min_rate'			=> $v->min_rate,
							'max_rate'			=> $v->max_rate,
							'is_top'			=> $v->rate_types->is_top,
							'default_rate'		=> $rateVal * 1000
						];
						break;
					}

				}

			}

			return response()->json(['success'=>['data' => $data]]);

        } catch (\Exception $e) {
			return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
		}
	}

	public function setRate(Request $request)
	{
		// if ($request->) {
		// 	# code...
		// }
	}
	 
}
