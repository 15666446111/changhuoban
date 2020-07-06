<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoPromotion extends Model
{
    protected $table = "auto_promotion";

    // 黑名单
    protected $guarded = [];


    public function groups()
    {
    	return $this->belongsTo('\App\UserGroup', 'group_id', 'id');
    }
}
