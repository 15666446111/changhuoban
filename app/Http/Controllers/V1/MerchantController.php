<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantController extends Controller
{
    
	/**
	 * @Author    Pudding
	 * @DateTime  2020-05-22
	 * @copyright [商户登记 获取用户所有未登记的机器列表]
	 * @license   [license]
	 * @version   [version]
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
	 * @version   [商户登记接口]
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
     * 商户列表接口
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

					// dd($value->merchants);
					$arrs['Bound'][] = array(
						'merchant_name'		=>		$value->name,
						'machine_phone'		=>		$value->phone,
						'merchant_sn'		=>		$sn,
						'money'				=>		$value->trades->sum('amount') / 100,
						'merchant_number'	=>		$value->code,
						'bind_time'			=>		$value->created_at
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
	 * 机具管理页面接口
	 */
	public function getBind(Request $request)
	{

		try{
			//获取用户的伙伴
			//
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
				$data['friend']['Merchant_status'] = \App\Machine::whereIn('user_id', $userAll)->where('open_state', '1')->count();
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
			$data['user']['Merchant_status'] = \App\Machine::where('user_id', $request->user->id)->where('open_state', '1')->count();
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
     * 机具详情接口
     */
    public function getMerchantsTail(Request $request)
    {
        try{

            //参数 friends伙伴  count总  user用户
			$Type = $request->Type;
			
            if(!$Type) return response()->json(['error'=>['message' => '缺少必要参数:详情类型']]);

            // dd($Type);
            $server = new \App\Http\Controllers\V1\ServersController($Type, $request->user);

            $data = $server->getInfo();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

        } catch (\Exception $e) {

			return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
		
		}

	}
	

	/**
     * 个人商户详情接口
     */
    public function merchantInfo(Request $request)
    {
        try{ 

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择终端']]);
             
            $data=\App\Machine::where('user_id',$request->user->id)
            ->where('id',$request->id)
			->first();
			
			$arrs;

			$arrs = array(

				'merchant_sn'			=>	$data->sn,
				'merchant_name'			=>	$data->machine_name,
				'merchant_phone'		=>	$data->machine_phone,
				'time'					=>	$data->bind_time ?? $data->created_at,
				'active_status'			=>	$data->activate_state
			);
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $arrs]]);   

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
     * 商户交易明细
     */
    public function MerchantDetails(Request $request)
    {

        try{ 
			
            if(!$request->merchant){
                return response()->json(['error'=>['message' => 'sn号无效']]);
            }

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

            $data = \App\Trade::select('cardType as card_type','card_number','trade_type','amount as money','trade_time')
            ->where('sn', $request->merchant)
            ->whereBetween('created_at', [$StartTime,  $EndTime])
			->get();
			
			if(!$data or empty($data)){
				$data[] = array(
					'card_type'		=>	'',
					'card_number'	=>	'',
					'trade_type'	=>	'',
					'money'			=>	'',
					'trade_time'	=>	''
				);
			}

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]);
        
        } catch (\Exception $e) {
                
            return response()->json(['error'=>['message' => '系统错误，请联系客服']]);

        }

    }
	 
}
