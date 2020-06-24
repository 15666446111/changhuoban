<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $table = 'orders';
 

    // 黑名单
    protected $guarded = [];

    public function Products(){

        return $this->hasone('App\Product','id','product_id');

    }
    
}
