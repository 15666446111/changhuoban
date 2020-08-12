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
     * @version [< 首页 - 机具管理 >]
     */
    Route::middleware('AuthToken')->get('/getBindAll', 'V1\MerchantController@getBind');        // 首页 - 机具管理 - 机具统计信息
    Route::middleware('AuthToken')->get('/getTail', 'V1\MerchantController@getMerchantsTail');  // 首页 - 机具管理 - 机具详情页面
    Route::middleware('AuthToken')->get('/getPolicy', 'V1\PolicyController@getPolicy');         // 首页 - 机具管理 - 机具划拨/机具回拨 - 获取政策列表
    Route::middleware('AuthToken')->get('/getUnBoundInfo', 'V1\TransferController@getUnBound'); // 首页 - 机具管理 - 机具划拨 - 用户未绑定终端机器
    Route::middleware('AuthToken')->post('/addTransfer', 'V1\TransferController@transfer');     // 首页 - 机具管理 - 机具划拨 - 选择划拨提交
    Route::middleware('AuthToken')->get('/sectionPolicy', 'V1\TransferController@sectionPolicy'); // 首页 - 机具划拨 - 区间划拨 - 区间查询
    Route::middleware('AuthToken')->get('/getBackList', 'V1\TransferController@backList');      // 首页 - 机具管理 - 机具回拨 - 选择回拨 - 回拨机器列表
    Route::middleware('AuthToken')->post('/addBackTransfer', 'V1\TransferController@backTransfer'); // 首页 - 机具管理 - 机具回拨 - 选择回拨 - 选择回拨提交
    Route::middleware('AuthToken')->get('/getTransferLog', 'V1\TransferController@transferLog');// 首页 - 机具管理 - 调拨记录页面


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
    Route::middleware('AuthToken')->get('/getMerchantsRate','V1\MerchantController@MerchantsRate'); // 首页 - 商户管理 - 获取商户费率
    Route::middleware('AuthToken')->post('/setMerchantsRate','V1\MerchantController@setRate'); // 首页 - 商户管理 - 修改商户费率

    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 - 伙伴管理 >]
     */
    Route::middleware('AuthToken')->get('/my_team', 'V1\TeamController@index');             // 首页 - 伙伴管理 - 伙伴列表
    Route::middleware('AuthToken')->get('/mine',    'V1\MineController@info');              // 首页 - 伙伴管理 - 伙伴详情


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 团队信息  >]
     */
    Route::middleware('AuthToken')->get('/team_data', 'V1\TeamController@data');            // 团队 - 团队信息
    Route::middleware('AuthToken')->post('/getTradeDetail', 'V1\TeamController@getDetail'); // 团队 - 业务详情
    Route::middleware('AuthToken')->get('/getTeamTradeDetail', 'V1\DetailController@TradeDetail');  // 团队-业务详情-交易量


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 收益信息 >]
     */
    Route::middleware('AuthToken')->get('/cashs', 'V1\CashsController@cashsIndex');              // 收益信息


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的栏位 >]
     */
    Route::middleware('AuthToken')->get('/userInfo', 'V1\SetUserController@getUserInfo');           // 我的 - 个人信息 
    //Route::middleware('AuthToken')->post('/updateUserInfo', 'V1\SetUserController@editUserInfo');   // 我的 - 修改头像
    Route::middleware('AuthToken')->post('/editAvatar', 'V1\SetUserController@editUserInfo');       // 我的 - 修改头像



    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的 微信分享 >]
     */
    Route::middleware('AuthToken')->get('/wx_share_list', 'V1\ArticleController@wxShare');
    


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的 消息通知 >]
     */
    Route::middleware('AuthToken')->get('/message', 'V1\MessageController@getMessage');             // 我的 - 消息通知 - 列表


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的 系统设置 >]
     */
    Route::middleware('AuthToken')->get('/setUserPwd', 'V1\LoginController@editUser');              // 我的 - 设置 - 修改密码
    Route::middleware('AuthToken')->get('/setUserInfo', 'V1\SetUserController@setUserInfos');       // 我的 - 设置 - 修改信息

    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的 设置 结算卡管理 >]
     */
    Route::middleware('AuthToken')->post('/createBank', 'V1\BankController@insertBank');        // 我的 - 结算卡 - 添加结算卡
    Route::middleware('AuthToken')->get('/getBankInfo', 'V1\BankController@selectBank');        // 我的 - 结算卡 - 查询结算卡
    Route::middleware('AuthToken')->get('/getBankDefault', 'V1\BankController@bankDefault');    // 我的 - 结算卡 - 默认结算卡
    Route::middleware('AuthToken')->get('/getBankFirst', 'V1\BankController@bankFirst');        // 我的 - 结算卡 - 单个结算卡
    Route::middleware('AuthToken')->get('/deBank', 'V1\BankController@unsetBank');              // 我的 - 结算卡 - 删除结算卡
    Route::middleware('AuthToken')->get('/upBank', 'V1\BankController@updateBank');             // 我的 - 结算卡 - 修改结算卡


    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 我的 设置 地址管理 >]
     */
    Route::middleware('AuthToken')->post('/addressAdd', 'V1\AddressController@address');        // 我的 - 设置 - 地址 - 添加地址
    Route::middleware('AuthToken')->get('/getAddress', 'V1\AddressController@getAAddress');     // 我的 - 设置 - 地址 - 查询地址
    Route::middleware('AuthToken')->get('/deAddress', 'V1\AddressController@deleteAddress');    // 我的 - 设置 - 地址 - 删除地址
    Route::middleware('AuthToken')->get('/upAddress', 'V1\AddressController@updateAddress');    // 我的 - 设置 - 地址 - 修改地址
    Route::middleware('AuthToken')->get('/getFirstAddress', 'V1\AddressController@firstAddress');// 我的 -设置 - 地址 - 单个地址    
    Route::middleware('AuthToken')->get('/getDefaultAddress', 'V1\AddressController@defaultAddress'); // 我的 - 地址 - 默认地址   



    /**
     * @author  [Pudding]  [<755969423@qq.com>]
     * @version [< 首页 伙伴管理 政策活动 >]
     */
    Route::middleware('AuthToken')->get('/userPolicyGroup', 'V1\PolicyController@getPolicyGroup');      // 首页 - 伙伴管理 - 获取活动组
    Route::middleware('AuthToken')->get('/userPolicy',      'V1\PolicyController@getPolicyList');       // 首页 - 伙伴管理 - 获取活动列表
    Route::middleware('AuthToken')->get('/userPrice',       'V1\PolicyController@getPrice');            // 首页 - 伙伴管理 - 获取结算价
    Route::middleware('AuthToken')->post('/setUserPrice',   'V1\PolicyController@setPrice');            // 首页 - 伙伴管理 - 设置结算价
    Route::middleware('AuthToken')->get('/getUserActive',   'V1\PolicyController@getActive');           // 首页 - 伙伴管理 - 获取激活返现
    Route::middleware('AuthToken')->post('/setUserActive',  'V1\PolicyController@setActive');           // 首页 - 伙伴管理 - 设置激活返现
    Route::middleware('AuthToken')->get('/getUserStandard', 'V1\PolicyController@getStandard');         // 首页 - 伙伴管理 - 获取达标奖励
    Route::middleware('AuthToken')->post('/setUserStandard',  'V1\PolicyController@setStandard');       // 首页 - 伙伴管理 - 设置达标奖励

    /**
     * @version [<APP 提现记录>] [<description>]
     * @return  [个人信息 获取提现记录]   [<description>]
     * @version [<提现记录信息接口] [<description>]
     */
    Route::middleware('AuthToken')->get('/draw', 'V1\MineController@draw_log');
    



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
     * 生成订单接口
     */
    Route::middleware('AuthToken')->post('/addOrderCreate', 'V1\OrdersController@orderCreate');


    /**
     * 查询订单接口
     */
    Route::middleware('AuthToken')->get('/getOrderUser', 'V1\OrdersController@getOrder');






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
     * 微信修改订单状态 
    */
    Route::middleware('AuthToken')->any('payments/wechat-notify', 'V1\OrdersController@paySuccess');



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