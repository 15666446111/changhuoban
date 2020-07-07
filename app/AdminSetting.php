<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{

    // 黑名单
    protected $guarded = ['account', 'password'];

    /**
     * [admin_setting 关联操盘设置表]
     * @return [type] [description]
     */
    public function admin_user()
    {
    	return $this->belongsTo('\App\AdminUser', 'operate', 'operate');
    }
}
