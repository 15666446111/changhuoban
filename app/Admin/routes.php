<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('admin-users', AdminUserController::class);

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
});
