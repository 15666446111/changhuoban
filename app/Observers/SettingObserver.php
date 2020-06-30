<?php

namespace App\Observers;

use App\AdminUser;

class SettingObserver
{
    /**
     * 当admin user 表 新增用户的时候， 判断新增的用户是否是操盘， 如果是操盘 初始化 操盘配置表
     * @return void
     */
    public function created(AdminUser $AdminUser)
    {
        // 初始化操盘方设置表
        if($AdminUser->type == "3"){
            \App\Setting::create([
                'operate'   =>  $AdminUser->operate
            ]);         
        }
    }
}
