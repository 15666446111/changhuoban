<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    // 操盘方设置表
    //$router->resource('settings', SettingController::class);
    $router->get('/settings', 'SettingController@index');

    $router->resource('admin-settings', AdminSettingController::class);

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
    // 联盟模式自动晋升
    $router->resource('auto-promotions', AutoPromotionController::class);

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

    $router->resource('merchants', MerchantController::class);  // 商户管理


    // 交易列表
    $router->resource('trades', TradeController::class);

    // 提現管理
    $router->resource('withdraws', WithdrawController::class);

    //产品列表管理
    $router->resource('products', ProductController::class);

    //订单列表管理
    $router->resource('orders', OrderController::class);

    //划拨回拨日志列表
    $router->resource('transfers', TransferController::class);


    //消息通知列表
    $router->resource('buser-messages', BuserMessageController::class);
    
    //分润管理
    $router->resource('cashs-logs', CashController::class);


    // 活动组管理
    $router->resource('policy-groups', PolicyGroupController::class);
    // 交易类型管理 有分润
    $router->resource('trade-types', TradeTypeController::class);
    // 组级别对应活动组的结算价
    $router->resource('policy-group-settlements', PolicyGroupSettlementController::class);
    // 活动组对应的费率
    $router->resource('policy-group-rates', PolicyGroupRateController::class);
    // 活动管理
    $router->resource('policies', PolicyController::class);

    // 商户短信管理
    $router->resource('admin-shorts', AdminShortController::class);


    // 节假日管理
    $router->resource('holidays', HolidayController::class);
    // 验证码
    $router->resource('sms-codes', SmsCodeController::class);


    // 1.1系统分润
    $router->resource('money-logs', MoneyLogController::class);
});
