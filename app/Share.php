<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
	/**
	 * [share_types 关联分享类型表]
	 * @author Pudding
	 * @DateTime 2020-04-16T10:24:14+0800
	 * @return   [type]                   [description]
	 */
	public function share_types()
	{
		return $this->belongsTo('App\ShareType', 'type_id', 'id');
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
     	return $query->where('active', '1')->where('verify', '1')->orderBy('sort', 'desc');
    }
     
    // 
    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取头像图片地址]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getImagesAttribute($value)
    {
        return "http://".$_SERVER["HTTP_HOST"]."/"."storage/".$value;
    }
}
