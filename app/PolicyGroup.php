<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyGroup extends Model
{
	public function settsprice()
	{
		return $this->hasMany('\App\PolicyGroupSettlement', 'policy_group_id', 'id');
	}

	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-30
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [关联活动]
	 * @return    [type]      [description]
	 */
	public function policys()
	{
		return $this->hasMany('\App\Policy', 'policy_group_id', 'id');
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-15
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 关联操盘方]
	 * @return    [type]      [description]
	 */
	public function operates()
	{
		return $this->belongsTo('\App\AdminSetting', 'operate', 'operate_number');
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-08-04
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 关联活动组费率表 ]
	 * @return    [type]      [description]
	 */
	public function policy_group_rate()
	{
		return $this->hasMany('\App\PolicyGroupRate', 'policy_group_id', 'id');
	}
}