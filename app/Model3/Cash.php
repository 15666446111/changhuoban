<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'money_log';

    // 黑名单
    protected $guarded = [];

}
