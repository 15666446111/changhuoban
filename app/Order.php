<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $table = 'orders';
 

    // 黑名单
    protected $guarded = [];

    // 反向关联产品表
    public function products(){
        return $this->belongsTo('App\Product','product_id','id');
    }
    
    //反向关联会员表
    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }

    //反向关联会员表
    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }
}
