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

	public function orders()
	{
		return $this->hasMany('\App\Orders','product_id','id');
	}


 	/** 获取图片头像 **/
 	public function getImageAttribute($value)
    {
    	return env("APP_URL")."/storage/".$value;
    }
    
}
