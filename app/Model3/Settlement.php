<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'pm_user_settle';

    // 黑名单
    protected $guarded = [];

}
