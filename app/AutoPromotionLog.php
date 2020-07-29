<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoPromotionLog extends Model
{
    protected $table = "auto_promotion_logs";

    // 黑名单
    protected $guarded = [];
}
