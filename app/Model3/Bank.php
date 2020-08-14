<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'bank';

    // 黑名单
    protected $guarded = [];

}
