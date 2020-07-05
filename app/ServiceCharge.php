<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    //
    protected $table = "service_charge";

	// 黑名单
	protected $guarded = [];
    
}
