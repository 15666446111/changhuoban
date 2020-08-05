<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantsFrozenLog extends Model
{
    // 黑名单
    protected $guarded = [];

    public function machines()
    {
    	return $this->belongsTo('\App\Machine', 'sn', 'sn');
    }
}
