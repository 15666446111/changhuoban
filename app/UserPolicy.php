<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPolicy extends Model
{
    
    // 黑名单
	protected $guarded = [];

    protected $casts = [
        'default_active_set'    => 'json',
        'vip_active_set'        => 'json'
    ];
    
	/**
	 * @Author    Pudding
	 * @DateTime  2020-05-21
	 * @copyright [ 结算价]
	 * @license   [license]
	 * @version   [version]
	 * @param     [type]      $extra [description]
	 * @return    [type]             [description]
	 */
    public function getSettPriceAttribute($extra)
    {
        return array_values(json_decode($extra, true) ?: []);
    }
    public function setSettPriceAttribute($extra)
    {
        $this->attributes['sett_price'] = json_encode(array_values($extra));
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-05-21
     * @copyright [ 普通用户达标 ]
     * @license   [license]
     * @version   [version]
     * @param     [type]      $extra [description]
     * @return    [type]             [description]
     */
    public function getStandardAttribute($extra)
    {
        $attr = json_decode($extra, true);
        foreach ($attr as $key => $value) {
            $attr[$key]['standard_trade'] = $value['standard_trade'] / 100;
            $attr[$key]['standard_price'] = $value['standard_price'] / 100;
        }
        return array_values($attr ?: []);
    }
    public function setStandardAttribute($extra)
    {
        $i = 1;
        foreach ($extra as $key => $value) {
            $extra[$key]['index'] = $value['index'] ?? $i;
            $extra[$key]['standard_trade'] = $value['standard_trade'] * 100;
            $extra[$key]['standard_price'] = $value['standard_price'] * 100;
            $i = isset($value['index']) ? $value['index'] + 1 : $i + 1;
        }
        $this->attributes['standard'] = json_encode(array_values($extra));
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-05-22
     * @copyright [关联用户模型]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function busers()
    {
    	return $this->belongsTo('\App\User', 'user_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-05-22
     * @copyright [关联用户模型]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function policys()
    {
    	return $this->belongsTo('\App\Policy', 'policy_id', 'id');
    }
    
}
