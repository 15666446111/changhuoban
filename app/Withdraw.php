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

    /**
     * 关联提现详情表
     * @return [type] [description]
     */
    public function withdrawDatas()
    {
    	return $this->hasOne('App\User', 'order_no', 'order_no');
    }
}
