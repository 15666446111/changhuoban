<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyGroupSettlement extends Model
{
	//
    protected $table = "policy_group_settlement";

	// 黑名单
	protected $guarded = [];
	
    /**
     * @version 活动组拥有的费率设置
     */
/*    public function setts()
    {
        return $this->belongsToMany('App\UserGroup', 'policy_group_settlement', 'policy_group_id', 'trade_type_id')->withPivot('set_price')->withTimestamps();
    }*/

    /**
     * [users  关联用户组模型模型]
     * @author Pudding
     * @DateTime 2020-04-20T13:43:38+0800
     * @return   [type]                   [description]
     */
    public function user_groups()
    {
        return $this->belongsTo('\App\UserGroup', 'user_group_id', 'id');
    }

    /**
     * [users  关联交易类型模型]
     * @author Pudding
     * @DateTime 2020-04-20T13:43:38+0800
     * @return   [type]                   [description]
     */
    public function trade_types()
    {
        return $this->belongsTo('\App\TradeType', 'trade_type_id', 'id');
    }
}
