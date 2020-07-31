<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{

    // 黑名单
    protected $guarded = [];

    /**
     * 关联用户表
     * @return [type] [description]
     */
    public function users()
    {
    	return $this->hasMany('\App\User', 'operate', 'operate');
    }

    /**
     * [admin_setting 关联操盘设置表]
     * @return [type] [description]
     */
    public function admin_setting()
    {
    	return $this->belongsTo('\App\AdminSetting', 'operate', 'operate_number');
    }

    /**
     * 关联轮播图表
     * @return [type] [description]
     */
    public function plugs()
    {
        return $this->hasMany('\App\Plug', 'operate', 'operate');
    }
}
