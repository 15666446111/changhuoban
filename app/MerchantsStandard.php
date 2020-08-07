<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantsStandard extends Model
{
    // 黑名单
	protected $guarded = [];

	/**
	 * [merchants 关联商户表]
	 * @return [type] [description]
	 */
	public function merchants()
	{
		return $this->belongsTo('\App\Merchant', 'merchant_code', 'code');
	}


	/**
	 * [merchants 关联机具表]
	 * @return [type] [description]
	 */
	public function machines()
	{
		return $this->belongsTo('\App\Machine', 'sn', 'sn');
	}
}
