<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterNotice extends Model
{
    
    protected $table = 'register_notice';
	// 黑名单
    protected $guarded = [];
    
}
