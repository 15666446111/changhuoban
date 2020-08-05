<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyGroupRate extends Model
{
    // 黑名单
	protected $guarded = [];


	/**
	 * [关联活动组]
	 * @return [type] [description]
	 */
	public function policy_group()
	{
		return $this->belongsTo('\App\PolicyGroup', 'policy_group_id', 'id');
	}

	/**
	 * [关联费率类型表]
	 * @return [type] [description]
	 */
	public function rate_types()
	{
		return $this->belongsTo('\App\MerchantsRateType', 'rate_type_id', 'id');
	}
}
