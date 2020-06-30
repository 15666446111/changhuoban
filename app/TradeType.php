<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeType extends Model
{

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
    public function setIsTopAttribute($value)
    {
    	$this->attributes['is_top'] = implode( ",", $value);
    } 
}
