<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlugType extends Model
{


	/**
	 * [plugs 关联轮播表]
	 * @author Pudding
	 * @DateTime 2020-04-16T10:24:14+0800
	 * @return   [type]                   [description]
	 */
	public function plugs()
	{
		return $this->hasMany('App\Plug', 'type_id', 'id');
	}
}
