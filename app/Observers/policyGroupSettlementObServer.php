<?php

namespace App\Observers;

use App\PolicyGroupSettlement;

/**
 *  结算价 observer
 *  当操盘修改或者设置活动组的结算价的时候触发
 *  仅限工具模式
 *  修改或设置结算价的时候 默认更改操盘方的结算价为最低结算价
 */
    
class policyGroupSettlementObServer
{

    
    /**
     * Handle the Settlement Price "updated" event.
     *
     * @param  \App\PolicyGroupSettlement  $PolicyGroupSettlement
     * @return void
     */
    public function updated(PolicyGroupSettlement $PolicyGroupSettlement)
    {
        
    	$policy = \App\PolicyGroup::where('id', $PolicyGroupSettlement->policy_group_id)->first();

    	if($policy->type == "2")
    	{
    		// 查询操盘方 登录账号
    		$operate 		= \App\AdminUser::where('operate', $policy->operate)->first();
    		$operateUser 	= \App\User::where('account', $operate->username)->first();

    		/**
    		 * 查询操盘方是否有当前活动组的结算价信息
    		 */
    		$Settlement = \App\UserFee::where('user_id', $operateUser->id)->where('policy_group_id', $policy->id)->first();

    		/**
    		 * 要设置的数据
    		 */
    		$body = array();

    		$list = PolicyGroupSettlement::where('policy_group_id', $policy->id)->get();

    		foreach ($list as $key => $value) {
    			$body[] = array('index' => $value->trade_type_id, 'price' => $value->min_price);
    		}

    		$body = json_encode($body);

    		/**
    		 * 如果没有结算价信息 需要新增一条
    		 */
    		if(empty($Settlement)){
    			\App\UserFee::create([
    				'user_id'			=>	$operateUser->id,
    				'policy_group_id'	=>	$policy->id,
    				'price'				=>	$body
    			]);
    		/**
    		 * 如果有结算价信息。需要更新
    		 */
    		}else{
    			$Settlement->price = $body;
    			$Settlement->save();
    		}


    	}

    }
}
