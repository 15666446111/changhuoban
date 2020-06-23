<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

	// 黑名单
    protected $guarded = [];
    
    /**
	 * [merchants 关联终端模型]
	 * @author Pudding
	 * @DateTime 2020-04-10T15:33:52+0800
	 * @return   [type]                   [description]
	 */
 	public function merchants()
 	{
 		return $this->hasMany('\App\Machine', 'brand_id', 'id');
    }
     
}
