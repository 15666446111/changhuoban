<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $table = 'orders';
 

    // 黑名单
    protected $guarded = [];
    
}
