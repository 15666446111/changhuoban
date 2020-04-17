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