<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantsRateType extends Model
{
    // 黑名单
	protected $guarded = [];

	/**
	 * [ 关联活动组费率表 ]
	 * @return [type] [description]
	 */
	public function policy_group_rate()
	{
		return $this->hasMany('\App\PolicyGroupRate', 'rate_type_id', 'id');
	}

	/**
	 * [关联交易类型表]
	 * @return [type] [description]
	 */
	public function trade_types()
	{
		return $this->belongsTo('\App\TradeType', 'trade_type_id', 'id');
	}
}
