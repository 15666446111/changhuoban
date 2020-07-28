<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 * @author  [Pudding]  [<755969423@qq.com>]
 * @version [<API路由的1.0版本>] [<description>]
 */
Route::prefix('V1')->group(function () {

    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 用户登陆 / 忘记密码 >] [< 无需token的路由 >]
     */
    Route::post('/login',       'V1\LoginController@login');                                // 用户登陆接口
    Route::post('/getCode',     'V1\LoginController@getCode');                              // 发送验证码接口
    Route::post('/forgetPwd',   'V1\LoginController@forget');                               // 忘记密码接口


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 >] [<  >]
     */
    Route::middleware('AuthToken')->get('/plug', 'V1\PlugController@index');                // 首页 - 轮播图
    Route::middleware('AuthToken')->get('/notice',  'V1\ArticleController@Notice');         // 首页 - 系统公告
    Route::middleware('AuthToken')->get('/article', 'V1\ArticleController@Article_detail'); // 首页 - 文章详情
    Route::middleware('AuthToken')->get('/problem', 'V1\ArticleController@problem');        // 首页 - 常见问题
    Route::middleware('AuthToken')->get('/index_info', 'V1\IndexController@info');          // 首页 - 信息统计

    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 >] [<  分享模块 生成分享海报 >]
     */
    Route::middleware('AuthToken')->get('/team_share',      'V1\ShareController@team');          // 首页 - 团队扩展
    Route::middleware('AuthToken')->get('/merchant_share',  'V1\ShareController@merchant');      // 首页 - 商户注册


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 - 商户登记 >]
     */
    Route::middleware('AuthToken')->get('/getNoBindMerchant', 'V1\MerchantController@getNoBindList');   // 首页 - 商户登记 - 未绑定列表
    Route::middleware('AuthToken')->get('/register', 'V1\MerchantController@registers');                // 首页 - 商户登记 - 提交登记资料


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 - 商户管理 >]
     */
    Route::middleware('AuthToken')->get('/getMerchantsList', 'V1\MerchantController@merchantsList');    // 首页 - 商户管理 - 商户列表
    Route::middleware('AuthToken')->get('/getMerchantInfo',  'V1\MerchantController@merchantInfo');     // 首页 - 商户管理 - 商户详情
    Route::middleware('AuthToken')->get('/getMerchantDetails','V1\MerchantController@MerchantDetails'); // 首页 - 商户管理 - 交易明细

    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 - 伙伴管理 >]
     */
    Route::middleware('AuthToken')->get('/my_team', 'V1\TeamController@index');             // 首页 - 伙伴管理 - 伙伴列表
    Route::middleware('AuthToken')->get('/mine',    'V1\MineController@info');              // 首页 - 伙伴管理 - 伙伴详情
    Route::middleware('AuthToken')->post('/getTradeDetail', 'V1\TeamController@getDetail');// 首页 - 伙伴管理 - 数据明细






    /**
     * @version [<APP 团队数据>] [<description>]
     * @return  [团队栏位 团队首页统计数据 日 月 总]   [<description>]
     * @version [<团队首页统计数据] [<description>]
     */
    Route::middleware('AuthToken')->get('/team_data', 'V1\TeamController@data');


    /**
     * @version [<APP 提现记录>] [<description>]
     * @return  [个人信息 获取提现记录]   [<description>]
     * @version [<提现记录信息接口] [<description>]
     */
    Route::middleware('AuthToken')->get('/draw', 'V1\MineController@draw_log');
    

    /**
     * 修改个人登录密码
     */
    Route::middleware('AuthToken')->get('/setUserPwd', 'V1\LoginController@editUser');

    /**
     * 获取用户信息
     */
    Route::middleware('AuthToken')->get('/userInfo', 'V1\SetUserController@getUserInfo');

    /**
     * 修改用户头像
    */
    Route::middleware('AuthToken')->post('/updateUserInfo', 'V1\SetUserController@editUserInfo');
    
    /**
     * 修改用户头像
    */
    Route::middleware('AuthToken')->post('/editAvatar', 'V1\SetUserController@editUserInfo');

    /**
     * @version [<vector>] [< 添加结算卡信息>]
     */
    Route::middleware('AuthToken')->post('/createBank', 'V1\BankController@insertBank');
    

    /**
     * @version [<vector>] [< 查询结算卡信息 >]
     */
    Route::middleware('AuthToken')->get('/getBankInfo', 'V1\BankController@selectBank');


    /**
     * @version [<vector>] [< 查询默认银行卡信息接口 >]
     */
    Route::middleware('AuthToken')->get('/getBankDefault', 'V1\BankController@bankDefault');


    /**
     * @version [<vector>] [< 查询单个银行卡信息接口 >]
     */
    Route::middleware('AuthToken')->get('/getBankFirst', 'V1\BankController@bankFirst');

    
    /**
     * @version [<vector>] [< 删除银行卡结算信息接口 >]
     */
    Route::middleware('AuthToken')->get('/deBank', 'V1\BankController@unsetBank');


    /**
     * @version [<vector>] [< 修改银行卡结算信息接口 >]
     */
    Route::middleware('AuthToken')->get('/upBank', 'V1\BankController@updateBank');


    /**
     * @version [<APP 获取产品类型接口>] [<description>]
     * @return  [获取正在展示的产品类型]   [<description>]
     * @version [<产品类型信息接口] [<description>]
     */
    Route::middleware('AuthToken')->get('/getproducttype', 'V1\ProductController@getType');


    /**
     * @version [<APP 获取产品类型--厂商接口>] [<description>]
    * @return  [获取正在展示的厂商]   [<description>]
    * @version [<产品厂商信息接口] [<description>]
    */
    Route::middleware('AuthToken')->get('/getproductfactories', 'V1\ProductController@getFactories');

    /**
     * @version [<APP 获取产品型号接口>] [<description>]
    * @return  [获取正在展示的产品型号]   [<description>]
    * @version [<产品型号信息接口] [<description>]
    */
    Route::middleware('AuthToken')->get('/getproductstyles', 'V1\ProductController@getStyles');

      /**
     * @version [<APP 获取产品列表接口>] [<description>]
     * @return  [获取正在展示的产品列表]   [<description>]
     * @version [<产品列表信息接口] [<description>]
     */
    Route::middleware('AuthToken')->get('/getproduct', 'V1\ProductController@getProduct');

    /**
     * @version [<APP 获取产品信息接口>] [<description>]
     * @return  [获取单独某个产品信息]   [<description>]
     * @version [<产品信息接口] [<description>]
     */
    Route::middleware('AuthToken')->get('/getproductinfo', 'V1\ProductController@getProductInfo');

     /**
     * 添加用户收货地址接口
     */
    Route::middleware('AuthToken')->post('/addressAdd', 'V1\AddressController@address');


    /**
     * 查询用户收货地址接口
     */
    Route::middleware('AuthToken')->get('/getAddress', 'V1\AddressController@getAAddress');


     /**
     * 删除用户收货地址接口
     */
    Route::middleware('AuthToken')->get('/deAddress', 'V1\AddressController@deleteAddress');
 

    /**
     * 修改用户收货地址接口
     */
    Route::middleware('AuthToken')->get('/upAddress', 'V1\AddressController@updateAddress');



    /**
     * 查询单个收货地址接口
     */
    Route::middleware('AuthToken')->get('/getFirstAddress', 'V1\AddressController@firstAddress');    


    
    /**
     * 查询默认收货地址接口
     */
    Route::middleware('AuthToken')->get('/getDefaultAddress', 'V1\AddressController@defaultAddress');    


      /**
     * 生成订单接口
     */
    Route::middleware('AuthToken')->post('/addOrderCreate', 'V1\OrdersController@orderCreate');


    /**
     * 查询订单接口
     */
    Route::middleware('AuthToken')->get('/getOrderUser', 'V1\OrdersController@getOrder');


    /* 收益页面接口
    */
   Route::middleware('AuthToken')->get('/cashs', 'V1\CashsController@cashsIndex');


   /**
    * 机具管理页面接口
    */
   Route::middleware('AuthToken')->get('/getBindAll', 'V1\MerchantController@getBind');

    /**
     * 机具管理页面接口
     */
    Route::middleware('AuthToken')->get('/getTail', 'V1\MerchantController@getMerchantsTail');

    
    /**
     * @version [<APP 获取政策活动列表>] [<description>]
     * @return  [获取平台所有的政策活动]   [<description>]
     * @version [<获取政策后的] [<description>]
     */
    Route::middleware('AuthToken')->get('/getPolicy', 'V1\PolicyController@getPolicy');




    /**
     * 查询用户未绑定终端机器
     */
    Route::middleware('AuthToken')->get('/getUnBoundInfo', 'V1\TransferController@getUnBound');
    

    /**
     * 划拨
     */
    Route::middleware('AuthToken')->post('/addTransfer', 'V1\TransferController@transfer');


    /**
     * 回拨机器列表
     */
    Route::middleware('AuthToken')->get('/getBackList', 'V1\TransferController@backList');


    /**
     * 回拨
     */
    Route::middleware('AuthToken')->post('/addBackTransfer', 'V1\TransferController@backTransfer');

    
    /**
     * 划拨回拨记录
     */
    Route::middleware('AuthToken')->get('/getTransferLog', 'V1\TransferController@transferLog');







     /**
     * @version [<APP 获取消息通知>] [<description>]
    * @return  [获取发送的消息接口]   [<description>]
    * @version [<消息通知信息接口] [<description>]
    */
    Route::middleware('AuthToken')->get('/message', 'V1\MessageController@getMessage');


    


    /**
     * @version [<APP 获取机具活动详情>] [<description>]
     * @return  [机具的达标返现与交易情况]   [<description>]
     * @version [<机具的达标返现情况] [<description>]
     */
    Route::middleware('AuthToken')->get('/getTerminalActiveDetail', 'V1\MerchantController@getActiveDetail');




    /**
     * @version  [<vector>] [<  获取机构提现配置  >]
     */
    Route::middleware('AuthToken')->get('/getPoint', 'V1\WithdrawController@point');


    /**
     * @version [<vector>] [< 用户与代理申请提现 >]
     */
    Route::middleware('AuthToken')->post('/getWithdrawal', 'V1\WithdrawController@apply');




    /**
     * 修改个人信息
     */
    Route::middleware('AuthToken')->get('/setUserInfo', 'V1\SetUserController@setUserInfos');

    /**
     * 微信修改订单状态 
    */
    Route::middleware('AuthToken')->any('payments/wechat-notify', 'V1\OrdersController@paySuccess');

    /**
     * @version [<获取微信分享文案>] [<description>]
     * @return  [<返回微信分享文案列表>]
     * @version [<微信分享文案列表>] 
     */
    Route::middleware('AuthToken')->get('/wx_share_list', 'V1\ArticleController@wxShare');
    

    /**
     * @version [<APP 获取某代理的商户分布情况 >] [<description>]
     * @return  [代理的商户分布情况]   [<description>]
     * @version [<获取某代理的商户分布情况] [<description>]
     */
    Route::middleware('AuthToken')->get('/getAgentMerchant', 'V1\AgentController@getAgentDetail');
    Route::middleware('AuthToken')->get('/getAgentTeam',     'V1\AgentController@getAgentTeamDetail');
    Route::middleware('AuthToken')->get('/getAgentTemail',   'V1\AgentController@getAgentTemail');
    Route::middleware('AuthToken')->get('/getAgentActive',   'V1\AgentController@getAgentActive');

});

Route::fallback(function(){ 
    return response()->json(['error'=>['message' => 'Request Error!']], 404);
});