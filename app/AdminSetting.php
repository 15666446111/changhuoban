<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{

    // 黑名单
    protected $guarded = ['account', 'password'];

    /**
     * [admin_setting 关联操盘用户表]
     * @return [type] [description]
     */
    public function admin_user()
    {
    	return $this->belongsTo('\App\AdminUser', 'operate', 'operate_number');
    }

    /**
     * [admin_short 关联操盘短信模板表]
     * @return [type] [description]
     */
    public function admin_short()
    {
        return $this->hasMany('\App\AdminShort', 'operate', 'operate_number');
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 关联操盘方下会员 ]
     * @return    [type]      [description]
     */
    public function users()
    {
        return $this->hasMany('\App\User', 'operate', 'operate_number');
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [操盘方关联操盘方设置表]
     * @return    [type]      [description]
     */
    public function settings()
    {
        return $this->hasOne('\App\Setting', 'operate', 'operate_number');
    }



    public function count_users()
    {
        return 3;
    }
}
