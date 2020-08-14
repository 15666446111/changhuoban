<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{

	protected $table = 'policies';
	// 黑名单
	protected $guarded = [];
	
    protected $casts = [
        'default_active_set'    => 'json',
    ];


	/**
	 * @Author    Pudding
	 * @DateTime  2020-05-21
	 * @copyright [ 普通用户达标 ]
	 * @license   [license]
	 * @version   [version]
	 * @param     [type]      $extra [description]
	 * @return    [type]             [description]
	 */
    public function getDefaultStandardSetAttribute($extra)
    {
        if($extra) {
            $attr = json_decode($extra, true);
            foreach ($attr as $key => $value) {
                $attr[$key]['standard_trade'] = $value['standard_trade'] / 100;
                $attr[$key]['standard_price'] = $value['standard_price'] / 100;
            }

            return array_values($attr ?: []);
        }else {
            return [];
        }
    }


    public function setDefaultStandardSetAttribute($extra)
    {
        //dd($extra);
        $i = 1;
    	foreach ($extra as $key => $value) {
            $extra[$key]['index'] = $value['index'] ?? $i;
    		$extra[$key]['standard_trade'] = $value['standard_trade'] * 100;
    		$extra[$key]['standard_price'] = isset($value['standard_price']) ? $value['standard_price'] * 100 : 0;
            $i = isset($value['index']) ? $value['index'] + 1 : $i + 1;
    	}
        $this->attributes['default_standard_set'] = json_encode(array_values($extra));
    }



	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-28
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [获取器]
	 * @param     [type]      $value [description]
	 */
	public function getActivePriceAttribute($value)
    {
    	return $value / 100;
    }
    public function setActivePriceAttribute($value)
    {
        $this->attributes['active_price'] =  $value * 100;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取器  直推激活返现 ]
     * @param     [type]      $value [description]
     */
    public function getDefaultActiveAttribute($value)
    {
        return $value / 100;
    }
    public function setDefaultActiveAttribute($value)
    {
        $this->attributes['default_active'] =  $value * 100;
    }    

    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 间推激活奖励 ]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getIndirectActiveAttribute($value)
    {
        return $value / 100;
    }
    public function setIndirectActiveAttribute($value)
    {
        $this->attributes['indirect_active'] =  $value * 100;
    }    

    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 间间推激活奖励 ]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getInIndirectActiveAttribute($value)
    {
        return $value / 100;
    }
    public function setInIndirectActiveAttribute($value)
    {
        $this->attributes['in_indirect_active'] =  $value * 100;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 流量卡费用 ]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getSimChargeAttribute($value)
    {
        return $value / 100;
    }
    public function setSimChargeAttribute($value)
    {
        $this->attributes['sim_charge'] =  $value * 100;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 工具模式的激活返现设置 ]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getDefaultActiveSetAttribute($value)
    {
        if($value != ""){
            $arrs = json_decode($value, true);
            foreach ($arrs as $key => $value)
                $arrs[$key] = $value / 100;
            return json_encode($arrs);        
        }else
            return $value;
    }
    public function setDefaultActiveSetAttribute($set)
    {
        if(!empty($set)){
            foreach ($set as $key => $value)
                $set[$key] = $value ? $value * 100 : 0;
            $this->attributes['default_active_set'] = json_encode($set);
        }else
            $this->attributes['default_active_set'] = "";
    }




	/**
	 * [merchants 关联终端模型]
	 * @author Pudding
	 * @DateTime 2020-04-10T15:33:52+0800
	 * @return   [type]                   [description]
	 */
 	public function machines()
 	{
 		return $this->hasMany('\App\Machine', 'policy_id', 'id');
 	}

    /**
     * [merchants 关联终端模型]
     * @author Pudding
     * @DateTime 2020-04-10T15:33:52+0800
     * @return   [type]                   [description]
     */
    public function policy_groups()
    {
        return $this->belongsTo('\App\PolicyGroup', 'policy_group_id', 'id');
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
     * [merchants 关联活动组结算价]
     * @author Pudding
     * @DateTime 2020-04-10T15:33:52+0800
     * @return   [type]                   [description]
     */
    public function settlements()
    {
        return $this->hasOne('\App\PolicyGroupSettlement', 'policy_group_id', 'id');
    }

}
