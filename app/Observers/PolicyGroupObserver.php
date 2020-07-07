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
        if($PolicyGroup->type == "1"){
            
            $group = \App\UserGroup::get();

            $type  = \App\TradeType::get();

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
    }
}
