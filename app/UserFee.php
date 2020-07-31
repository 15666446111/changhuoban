<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFee extends Model
{
    protected $table = 'user_fees';
 
    // 黑名单
    protected $guarded = [];
}
