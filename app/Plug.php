<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plug extends Model
{
	/**
	 * [plugs 关联轮播类型表]
	 * @author Pudding
	 * @DateTime 2020-04-16T10:24:14+0800
	 * @return   [type]                   [description]
	 */
	public function plug_types()
	{
		return $this->belongsTo('App\PlugType', 'type_id', 'id');
	}

    /**
     * [admin_users 关联操盘方表]
     * @author Pudding
     * @DateTime 2020-07-21T16:49:00+0800
     * @return   [type]                   [description]
     */
    public function admin_users()
    {
        return $this->belongsTo('App\AdminUser', 'operate', 'operate');
    }


	/**
	 * [scopeApiGet 搜索过滤选项]
	 * @author Pudding
	 * @DateTime 2020-04-27T17:28:37+0800
	 * @param    [type]                   $query [description]
	 * @return   [type]                          [description]
	 */
    public function scopeApiGet($query)
    {
    	return $query->where('active', '1')->where('verify', '1')->orderBy('sort', 'desc')->limit('3')->select([
    		'id',
    		'name',
    		'images', 
    		'href'
    	]);
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取图片地址]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getImagesAttribute($value)
    {
        return "http://".$_SERVER["HTTP_HOST"]."/"."storage/".$value;
    }
}
