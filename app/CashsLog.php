<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashsLog extends Model
{
    protected $table = 'cashs_logs';
    
    // 黑名单
    protected $guarded = ['id'];
    
    //
    /**
     * 收益表反向关联用户表
     */
    public function users()
    {
        return $this->hasMany('\App\User', 'id', 'user_id');
    }


	/**
	 * [merchants 关联商户模型]
	 * @author Pudding
	 * @DateTime 2020-04-10T16:37:46+0800
	 * @return   [type]                   [description]
	 */
    public function trades()
    {
    	return $this->belongsTo('\App\Trade', 'trade_id', 'id');
    }
}
