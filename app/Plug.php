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
}
