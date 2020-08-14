<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'pm_settle_type';

    // 黑名单
    protected $guarded = [];

}
