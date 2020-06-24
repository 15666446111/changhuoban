<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    
    protected $table = 'transfers';
 

    // 黑名单
    protected $guarded = [];

    /**
     * 关联用户表
     */
    public function old_user()
    {
        return $this->hasOne('App\User','id','old_user_id');
    }

    /**
     * 关联用户表
     */
    public function new_user()
    {
        return $this->hasOne('App\User','id','new_user_id');
    }

    /**
     * 关联机器信息
     */
    public function machine()
    {
        return $this->hasOne('App\Machine','id','machine_id');
    }

}
