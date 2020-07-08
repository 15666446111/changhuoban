<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{

	protected $table = 'policies';
	// 黑名单
	protected $guarded = [];
	
    protected $casts = [
        'default_active_set' 	=> 'json',
        'vip_active_set' 		=> 'json'
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
                $attr[$key]['standard_agent_price'] = $value['standard_agent_price'] / 100;
                $attr[$key]['standard_trade'] = $value['standard_trade'] / 100;
                $attr[$key]['standard_price'] = $value['standard_price'] / 100;
                $attr[$key]['standard_parent_price'] = $value['standard_parent_price'] / 100;
            }

            return array_values($attr ?: []);
        }else {
            return [];
        }

    }
    public function setDefaultStandardSetAttribute($extra)
    {
        $i = 1;
    	foreach ($extra as $key => $value) {
            $extra[$key]['index'] = $value['index'] ?? $i;
    		$extra[$key]['standard_trade'] = $value['standard_trade'] * 100;
            $extra[$key]['standard_agent_price'] = $value['standard_agent_price'] * 100;
    		$extra[$key]['standard_price'] = $value['standard_price'] * 100;
    		$extra[$key]['standard_parent_price'] = $value['standard_parent_price'] * 100;
            $i = isset($value['index']) ? $value['index'] + 1 : $i + 1;
    	}
        $this->attributes['default_standard_set'] = json_encode(array_values($extra));
    }


	/**
	 * @Author    Pudding
	 * @DateTime  2020-05-21
	 * @copyright [ 代理用户达标 ]
	 * @license   [license]
	 * @version   [version]
	 * @param     [type]      $extra [description]
	 * @return    [type]             [description]
	 */
    public function getVipStandardSetAttribute($extra)
    {
        return array_values(json_decode($extra, true) ?: []);
    }
    public function setVipStandardSetAttribute($extra)
    {
        $this->attributes['vip_standard_set'] = json_encode(array_values($extra));
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
