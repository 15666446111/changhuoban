<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
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
	 * [machines 关联机具模型]
	 * @return [type] [description]
	 */
	public function machines()
	{
		return $this->hasMany('\App\Machine', 'merchant_id', 'id');
	}
}
