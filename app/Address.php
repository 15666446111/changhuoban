<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
 

    // 黑名单
	protected $guarded = [];
}
