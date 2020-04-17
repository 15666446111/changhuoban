<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareType extends Model
{
	/**
	 * [shares 关联分享表]
	 * @author Pudding
	 * @DateTime 2020-04-16T10:24:14+0800
	 * @return   [type]                   [description]
	 */
	public function shares()
	{
		return $this->hasMany('App\Share', 'type_id', 'id');
	}
}
