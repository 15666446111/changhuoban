<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    protected $guarded = [];

    /**
     * [User 关联用户会员模型]
     * @author Pudding
     * @DateTime 2020-04-10T15:35:13+0800
     * @return   [type]                   [description]
     */
    public function users()
    {
    	return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
