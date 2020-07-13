<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
	
	protected $table = 'cashs';

    // 黑名单
    protected $guarded = [];

    /**
     * @Author    Pudding
     * @DateTime  2020-07-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 关联交易表 ]
     * @return    [type]      [description]
     */
    public function trades()
    {
    	return $this->belongsTo('\App\Trade', 'order', 'trade_no');
    }

    /**
     * [users 反向关联用户表]
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
