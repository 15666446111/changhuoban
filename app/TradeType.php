<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeType extends Model
{

    /**
     * [users  关联活动组结算价模型]
     * @author Pudding
     * @DateTime 2020-04-20T13:43:38+0800
     * @return   [type]                   [description]
     */
    public function policy_sett()
    {
        return $this->HasMany('\App\PolicyGroupSettlement', 'trade_type_id', 'id');
    }

    /**
     * [rate_types  关联商户费率类型表]
     * @author Pudding
     * @DateTime 2020-08-05
     * @return   [type]                   [description]
     */
    public function rate_types()
    {
        return $this->HasMany('\App\MerchantsRateType', 'trade_type_id', 'id');
    }

    // 设置交易标识
    public function getTradeTypeAttribute($value)
    {
        return explode(",", $value);
    } 
    // 获取交易标识
    public function setTradeTypeAttribute($value)
    {
    	$this->attributes['trade_type'] = implode( ",", $value);
    } 

    // 获取交易卡类型
    public function getCardTypeAttribute($value)
    {
        return explode(",", $value);
    } 
    // 设置交易卡类型
    public function setCardTypeAttribute($value)
    {
    	$this->attributes['card_type'] = implode( ",", $value);
    } 

    // 获取手续费标准
    public function getTradeCodeAttribute($value)
    {
        return explode(",", $value);
    } 
    // 设置交易卡类型
    public function setTradeCodeAttribute($value)
    {
    	$this->attributes['trade_code'] = implode( ",", $value);
    } 

    // 获取是否封顶
    public function getIsTopAttribute($value)
    {
        return explode(",", $value);
    } 
    // 设置是否封顶
    // public function setIsTopAttribute($value)
    // {
    // 	$this->attributes['is_top'] = implode( ",", $value);
    // }
}
