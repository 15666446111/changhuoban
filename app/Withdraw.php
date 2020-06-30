<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    
    protected $guarded = [];

    /**
     * 反向关联用户表
     */
    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
