<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;

use Encore\Admin\Config\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @version [<新增用户 / 用户注册 / 用户模型发生新增事件的时候 执行观察者 >] 
         * @description [<初始化用户数据>]
         * @author  [Pudding] <[< 755969423@qq.com >]>
         */
        User::observe(UserObserver::class);

        // 轮播图监听
        \App\Plug::observe(\App\Observers\PlugObserver::class);
        // 轮播图类型监听
        \App\PlugType::observe(\App\Observers\PlugTypeObserver::class);

        // 分享素材监听
        \App\Share::observe(\App\Observers\ShareObserver::class);
        // 分享类型监听
        \App\ShareType::observe(\App\Observers\ShareTypeObserver::class);

        // 文章内容监听
        \App\Article::observe(\App\Observers\ArticleObserver::class);
        // 文章类型监听
        \App\ArticleType::observe(\App\Observers\ArticleTypeObserver::class);



        /**
         * [$table Config Database Auto Load To Config]
         * @var [自动加载配置表到Config]
         */
        $table = config('admin.extensions.config.table', 'admin_config');
        
        if (Schema::hasTable($table)) {
            Config::load();
        }
    }
}
