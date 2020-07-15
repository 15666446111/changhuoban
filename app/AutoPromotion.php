<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoPromotion extends Model
{
    protected $table = "auto_promotion";

    // 黑名单
    protected $guarded = [];


    public function groups()
    {
    	return $this->belongsTo('\App\UserGroup', 'group_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-15
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 关联操盘方]
     * @return    [type]      [description]
     */
    public function operates()
    {
        return $this->belongsTo('\App\AdminSetting', 'operate', 'operate_number');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [设置器 自动转化为分单位]
     * @param     [type]      $value [description]
     */
    public function setTradeCountAttribute($value)
    {
        $this->attributes['trade_count'] = (int)($value * 100);
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取器 自动转化为分单位]
     * @param     [type]      $value [description]
     */
    public function getTradeCountAttribute($value)
    {
        return $value / 100;
    }
}
