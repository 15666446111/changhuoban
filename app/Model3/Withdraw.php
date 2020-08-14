<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'tixian_log';

    // 黑名单
    protected $guarded = [];

}
