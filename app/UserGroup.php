<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{

	/**
	 * [users  关联User模型]
	 * @author Pudding
	 * @DateTime 2020-04-20T13:43:38+0800
	 * @return   [type]                   [description]
	 */
	public function users()
	{
		return $this->HasMany('\App\User', 'user_group', 'id');
	}
}
