<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantsFrozenLog extends Model
{
    // 黑名单
    protected $guarded = [];

    public function machines()
    {
    	return $this->belongsTo('\App\Machine', 'sn', 'sn');
    }

    /**
     * [getFrozenMoneyAttribute 访问器]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getFrozenMoneyAttribute($value)
    {
    	return $value / 100;
    }

    /**
     * [setFrozenMoneyAttribute 设置器]
     * @param [type] $value [description]
     */
    public function setFrozenMoneyAttribute($value)
    {
        $this->attributes['frozen_money'] = $value * 100;
    }
}
