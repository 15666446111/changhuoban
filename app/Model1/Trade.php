<?php

namespace App\Model1;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql_1_1';

    protected $table = 'trade_data';

    // 黑名单
    protected $guarded = [];


    // 操盘方
    public function cash()
    {
    	return $this->hasMany('\App\Model1\MoneyLog', 't_id', 'id');
    }
}
