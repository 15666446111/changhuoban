<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    //
    $router->resource('admin-settings', AdminSettingController::class);


    $router->resource('admin-users', AdminUserController::class);

    // 操盘方设置表
    $router->resource('settings', SettingController::class);
    
    // 轮播图类型管理
    $router->resource('plug-types', PlugTypeController::class);
    // 轮播图管理
    $router->resource('plugs', PlugController::class);

    // 分享类型管理
    $router->resource('share-types', ShareTypeController::class);
    // 分享管理
    $router->resource('shares', ShareController::class);

    // 代理管理
    $router->resource('users', UserController::class);
    // 用户组管理
    $router->resource('user-groups', UserGroupController::class);

    // 文章类型管理
    $router->resource('article-types', ArticleTypeController::class);

    // 文章列表管理
    $router->resource('articles', ArticleController::class);

    /**
     * 机器仓库管理Route
     */
    $router->resource('machines-types', MachinesTypeController::class); // 机器类型
    $router->resource('machines-factories', MachinesFactoryController::class); // 机器厂商
    $router->resource('machines-styles', MachinesStyleController::class); // 机器型号
    $router->resource('machines', MachineController::class);  // 仓库管理



    // 交易列表
    $router->resource('trades', TradeController::class);


    // 提現管理
    $router->resource('withdraws', WithdrawController::class);

    //产品列表管理
    $router->resource('products', ProductController::class);

    //订单列表管理
    $router->resource('orders', OrderController::class);
    
});
