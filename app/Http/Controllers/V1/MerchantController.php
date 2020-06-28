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
     * 首页商户登记绑定接口
     */
    public function registers(Request $request)
    {
        try{ 
			 $data = \App\Machine::where('user_id',$request->user->id)->where('sn',$request->merchant_sn)->first();
			 
			 $data->machine_name = $request->merchant_name;
			 $data->machine_phone = $request->merchant_phone;
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

			$data = \App\Merchant::where('state',1)->where('user_id',$request->user->id)->get();
			
			if(!$data or empty($data)){
				$arrs['Bound'][] = [];
			}

			$arrs;

			foreach($data as $key=>$value){
				
				$arrs['Bound'][] = array(

					'id'				=>		$value->id,
					'merchant_name'		=>		$value->name,
					'machine_phone'		=>		$value->phone,
					'merchant_sn'		=>		$value->activate_sn,
					'money'				=>		$value->trade_amount / 100,
					'machine_id'		=>		$value->machines->id,
					'created_at'		=>		$value->machines->bind_time

				);
			}

			$UnBind = \App\Machine::where('user_id',$request->user->id)->where('bind_status',0)->get();

			if(!$UnBind or empty($UnBind)){
				$arrs['UnBound'][] = [];
			}

			foreach($UnBind as $key=>$value){

				$arrs['UnBound'][] = array(

					'id'				=>		'',
					'merchant_name'		=>		'',
					'machine_phone'		=>		'',
					'merchant_sn'		=>		$value->sn,
					'money'				=>		'',
					'machine_id'		=>		$value->id,
					'created_at'		=>		$value->bind_time

				);

			}
			
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $arrs]]); 

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

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
            
            return response()->json(['error'=>['message' => $e->getMessage()]]);

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
            // dd($Type);
            $server = new \App\Http\Controllers\V1\ServersController($Type, $request->user);

            $data = $server->getInfo();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

        } catch (\Exception $e) {

			return response()->json(['error'=>['message' => $e->getMessage()]]);
		
		}

	}
	

	/**
     * 个人商户详情接口
     */
    public function merchantInfo(Request $request)
    {
        try{ 
             
            $data=\App\Machine::where('user_id',$request->user->id)
            ->where('id',$request->id)
            ->first();
            
            $data['time'] = $data->bind_time ? $data->bind_time : $data->activate_time;
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);   

    	} catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误，请联系客服']]);

        }
    }
	 
}
