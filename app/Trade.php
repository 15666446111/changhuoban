<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    /**
     * [$guarded 黑名单设置]
     * @var array
     */
    protected $guarded = [];

    /**
	 * [merchants 反向关联收益]
	 * @author Pudding
	 * @DateTime 2020-04-10T16:37:46+0800
	 * @return   [type]                   [description]
	 */
    public function trades_cash()
    {
    	return $this->hasMany('\App\CashsLog', 'trade_id', 'id');
    }
}
