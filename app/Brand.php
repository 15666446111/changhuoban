<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

	// 黑名单
    protected $guarded = [];
    
    /**
	 * [merchants 关联品牌模型]
	 * @author Pudding
	 * @DateTime 2020-04-10T15:33:52+0800
	 * @return   [type]                   [description]
	 */
 	public function products()
 	{
 		return $this->hasMany('\App\Product', 'type', 'id');
    }
     
}
