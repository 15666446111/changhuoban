<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterNotice extends Model
{
    
    protected $table = 'register_notice';
	// 黑名单
    protected $guarded = [];


    /**
     * [merchants 关联机具模型 通过sn关联]
     * @author Pudding 
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function machines()
    {
        return $this->belongsTo('\App\Machine', 'termSn', 'sn');
    }
    
}
