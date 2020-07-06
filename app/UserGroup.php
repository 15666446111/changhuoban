<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{

	/**
	 * [users  关联User模型]
	 * @author Pudding
	 * @DateTime 2020-04-20T13:43:38+0800
	 * @return   [type]                   [description]
	 */
	public function users()
	{
		return $this->HasMany('\App\User', 'user_group', 'id');
	}

	/**
	 * [users  关联User模型]
	 * @author Pudding
	 * @DateTime 2020-04-20T13:43:38+0800
	 * @return   [type]                   [description]
	 */
	public function auto_promos()
	{
		return $this->HasMany('\App\AutoPromotion', 'group_id', 'id');
	}

	/**
	 * [users  关联活动组结算价模型]
	 * @author Pudding
	 * @DateTime 2020-04-20T13:43:38+0800
	 * @return   [type]                   [description]
	 */
	public function policy_sett()
	{
		return $this->HasMany('\App\PolicyGroupSettlement', 'user_group_id', 'id');
	}

	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-28
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [设置器]
	 * @param     [type]      $value [description]
	 */
	public function setTradeCountAttribute($value)
    {
    	$this->attributes['trade_count'] = (int)($value * 100);
    }

	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-28
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [获取器]
	 * @param     [type]      $value [description]
	 */
	public function getTradeCountAttribute($value)
    {
    	return $value / 100;
    }
}
