<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{

    
    protected $guarded = [];


    /**
     * [machines_styles 关联机具类型表]
     * @author Pudding
     * @DateTime 2020-04-21T15:06:02+0800
     * @return   [type]                   [description]
     */
    public function machines_styles()
    {
    	return $this->belongsTo('App\MachinesStyle', 'style_id', 'id');
    }

    /**
     * [users 机具关联代理]
     * @author Pudding
     * @DateTime 2020-04-22T17:38:41+0800
     * @return   [type]                   [description]
     */
    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    /**
     * [busers 关联终端品牌模型]
     * @author Pudding
     * @DateTime 2020-04-10T15:35:13+0800
     * @return   [type]                   [description]
     */
    public function brands()
    {
        return $this->belongsTo('\App\Brand', 'brand_id', 'id');
    }

    /**
     * [merchants 关联商户模型]
     * @return [type] [description]
     */
    public function merchants()
    {
        return $this->belongsTo('\App\Merchant', 'merchant_id', 'id');
    }

    /**
     * [busers 关联终端活动政策模型]
     * @author Pudding
     * @DateTime 2020-04-10T15:35:13+0800
     * @return   [type]                   [description]
     */
    public function policys()
    {
        return $this->belongsTo('\App\Policy', 'policy_id', 'id');
    }


    /**
     * 关联划拨日志
     */
    public function transfer()
    {
        return $this->hasOne('App\Transfer','id','machine_id');
    }


    /**
     * [merchants 关联交易模型 通过SN关联]
     * @author Pudding
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function tradess_sn()
    {
        return $this->hasMany('\App\Trade', 'sn', 'sn');
    }


    /**
     * [merchants 关联交易模型 通过SN关联]
     * @author Pudding
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function cashs()
    {
        return $this->hasMany('\App\CashLog', 'machine_id', 'id');
    }

    /**
     * [merchants 关联冻结记录表]
     * @author Pudding
     * @DateTime 2020-07-31
     * @return   [type]                   [description]
     */
    public function frozen_log()
    {
        return $this->hasMany('\App\MerchantsFrozenLog', 'sn', 'sn');
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
        return $this->hasMany('\App\MerchantsStandard', 'sn', 'sn');
    }

}
