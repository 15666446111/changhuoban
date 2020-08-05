<?php

namespace App\Observers;

use App\PolicyGroup;

class PolicyGroupObserver
{
    /**
     * Handle the user "created" event.
     * 1. Init User Wallet Table Datas
     * 2. Init User Relation Table Datas.
     * 3. Init User RelaName Table Datas.
     * @param  \App\App\User  $user
     * @return void
     */
    public function created(PolicyGroup $PolicyGroup)
    {
        $type  = \App\TradeType::get();

        $rateType = \App\MerchantsRateType::get();

        // 联盟模式
        if($PolicyGroup->type == "1"){
            $group = \App\UserGroup::get();
            foreach ($group as $key => $value) {
                foreach ($type as $k => $v) {
                    \App\PolicyGroupSettlement::create([ 
                        'policy_group_id'   =>  $PolicyGroup->id,
                        'trade_type_id'     =>  $v->id,
                        'user_group_id'     =>  $value->id,
                        'set_price'         =>  0,
                    ]);
                }
            }
        }

        // 如果是工具模式
        if($PolicyGroup->type == "2")
        {
            // 初始化活动组结算价信息
            foreach ($type as $k => $v) {
                \App\PolicyGroupSettlement::create([ 
                    'policy_group_id'   =>  $PolicyGroup->id,
                    'trade_type_id'     =>  $v->id,
                    'user_group_id'     =>  0,
                    'set_price'         =>  0,
                ]);
            }

            // 初始化活动组费率信息
            foreach ($rateType as $k => $v) {
                \App\PolicyGroupRate::create([
                    'policy_group_id'   => $PolicyGroup->id,
                    'rate_type_id'      => $v->id,
                    'min_rate'          => $v->default_min_rate,
                    'max_rate'          => $v->default_max_rate
                ]);
            }
        }
    }
}
