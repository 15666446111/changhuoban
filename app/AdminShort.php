<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminShort extends Model
{
    
    protected $table = 'admin_short';
    
    // 黑名单
    protected $guarded = [];

}
