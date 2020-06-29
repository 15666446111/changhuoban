<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuserMessage extends Model
{

    protected $table = 'buser_messages';
    
    // 黑名单
    protected $guarded = [];
}
