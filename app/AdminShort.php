<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminShort extends Model
{
    
    protected $table = 'admin_short';
    
    // 黑名单
    protected $guarded = [];



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
		return $this->belongsTo('\App\AdminSetting', 'agent_id', 'system_merchant');
	}
}
