<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'house';

    // 黑名单
    protected $guarded = [];


    public function logs()
    {
    	return $this->hasMany('\App\Model3\HouseBindLog', 'sn', 'sm');
    }
}
