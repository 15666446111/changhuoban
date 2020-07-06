<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{

    protected $guarded = [];
    
    /**
     * [busers 用户模型反向关联]
     * @author Pudding
     * @return   [type]                   [description]
     */
	public function users()
	{
        return $this->belongsTo('\App\User', 'user_id', 'id');
	}

	 /**
     * [merchants 关联机具模型 通过id关联]
     * @author Pudding 
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function machines()
    {
        return $this->hasMany('\App\Machine', 'id', 'merchant_id');
    }

    public function trades()
    {
        # code...
    }
}
