<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	
    // 黑名单
	protected $guarded = [];
		
    /**
	 * @Author    Pudding
	 * @DateTime  2020-06-10
	 * @copyright [copyright]
	 * @license   [关联产品品牌]
	 * @version   [version]
	 * @return    [type]      [description]
	 */
	public function brands()
	{
		return $this->belongsTo('\App\Brand', 'type', 'id');
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-10
	 * @copyright [copyright]
	 * @license   [关联类型品牌]
	 * @version   [version]
	 * @return    [type]      [description]
	 */
	public function style()
	{
		return $this->belongsTo('\App\MachinesStyle', 'style_id', 'id');
	}

	/**
	 * 关联订单品牌
	 */
	public function orders()
	{
		return $this->hasMany('\App\Orders','product_id','id');
	}


 	/** 获取图片头像 **/
 	public function getImageAttribute($value)
    {
    	return env("APP_URL")."/storage/".$value;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [设置器 ， 将存入到数据库中product表的price字段 自动转化为分单位]
     * @param     [type]      $value [description]
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (int)($value * 100);
    }


    public function getPriceAttribute($value)
    {
    	return $value / 100 ;
    }

}
