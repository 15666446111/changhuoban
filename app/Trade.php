<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    /**
     * [$guarded 黑名单设置]
     * @var array
     */
    protected $guarded = [];


    /**
     * @Author    Pudding
     * @DateTime  2020-07-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 关联分润表 ]
     * @return    [type]      [description]
     */
    public function cashs()
    {
        return $this->hasMany('\App\Cash', 'order', 'trade_no');
    }


    /**
     * [merchants 关联商户模型 通过SN关联]
     * @author Pudding
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function merchants_sn()
    {
        return $this->belongsTo('\App\Machine', 'sn', 'sn');
    }


    /**
     * [merchants 关联用户 通过ID关联]
     * @author Pudding
     * @DateTime 2020-04-10T16:37:46+0800
     * @return   [type]                   [description]
     */
    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    /**
     * [trades_deputies 关联交易副表]
     * @return [type] [description]
     */
    public function trades_deputies()
    {
        return $this->belongsTo('\App\TradesDeputy', 'id', 'trade_id');
    }

    /**
     * [merchants 关联商户表]
     * @return [type] [description]
     */
    public function merchants()
    {
        return $this->belongsTo('\App\Merchant', 'merchant_code', 'code');
    }

}
