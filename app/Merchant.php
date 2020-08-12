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
        return $this->hasMany('\App\Machine', 'merchant_id', 'id');
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [关联交易表]
     * @return    [type]      [description]
     */
    public function trades()
    {
        return $this->hasMany('\App\Trade', 'merchant_code', 'code');
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-08-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [关联达标记录表]
     * @return    [type]      [description]
     */
    public function standard_logs()
    {
        return $this->hasMany('\App\MerchantsStandard', 'merchant_code', 'code');
    }
}
