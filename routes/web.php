<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 访问项目主地址
Route::get('/', 		'HomeController@index');

// 忘记密码地址
Route::get('/forget', 	'RegisterController@forget');

// 项目登录之后的主页面
Route::get('/home', 	'HomeController@home');





/**
 * @version [<通知接口>] [< 助代通通知接口  助代通开通通知 ， 交易流水通知>]
 * @version [<vector>]  [<系统总平台 包括操盘方 所有的通知接口都会推送到此地址>]
 */
Route::post('/trade', 	'TradeApiController@index');


/**
 * @version [<vector>] [<后台联动Select 查询符合条件的厂家>]
 */
Route::get('/api/getAdminFactory', 		'AdminApiController@getAdminFactory');