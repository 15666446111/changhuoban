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

/**
 * @version [<vector>] [< Admin 后端使用数据接口>]
 * @author  <[< 755969423@qq.com >]>
 */









/**
 * @version [<vector>] [< 获取轮播图类型>]
 */
Route::get('/getPlugType', 'AdminApiController@getPlugType');
/**
 * @version [<vector>] [< 获取分享类型 >]
 */
Route::get('/getShareType', 'AdminApiController@getShareType');