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
}
