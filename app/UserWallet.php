<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $guarded = [];

    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取分润钱包金额 单位 元]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getCashBlanceAttribute($value)
    {
    	return $value / 100 ;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取返现钱包金额 单位 元]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getReturnBlanceAttribute($value)
    {
    	return $value / 100 ;
    }


    public function countBlance()
    {
    	return 1000;
    }
}
