<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{

    // 黑名单
    protected $guarded = ['account', 'password'];
}
