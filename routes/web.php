<?php

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

Route::get('/', function () {
    return view('welcome');
});
//git推送到github后浏览器自动拉取pull
Route::any('/Gitpull', 'Git\Gitpull@pull');
//没用的~~
Route::any('/aaa', 'Git\Gitpull@pulla');

Route::prefix('wechat')->group(function () {
    Route::any('/', 'Admin\Wechat@index');
    Route::any('/menus', 'Admin\Wechat@menus'); //自定义菜单
    Route::any('/mass', 'Admin\Wechat@mass');   //群发
    Route::any('/masstexting', 'Admin\Wechat@masstexting');   //群发
});

//登录模板
Route::prefix('login')->group(function () {
    Route::get('/','Admin\Login@create');//登录视图
    Route::post('store','Admin\Login@store');//执行登录
    Route::get('index','Admin\Login@index');//展示页面
    Route::get('show','Admin\Login@show');//**页面
});
//->middleware('checkLogin')

//天气展示
Route::prefix('weather')->group(function () {
    Route::any('/','Admin\Weather@index');//展示页面
    Route::any('/create','Admin\Weather@create');//展示页面
});

//素材模板
Route::prefix('material')->group(function () {
    Route::any('/','Admin\Material@index');//展示页面
    Route::any('create','Admin\Material@create');//添加视图
    Route::any('store','Admin\Material@store');//执行添加
});

//新闻模板
Route::prefix('news')->group(function () {
    Route::any('/','Admin\News@index');//展示页面
    Route::any('create','Admin\News@create');//添加视图
    Route::any('store','Admin\News@store');//执行添加
});
Route::prefix('wnews')->group(function () {
    Route::any('/', 'Admin\Wnews@index');
});
//生成二维码
Route::prefix('quick')->group(function () {
    Route::any('/','Admin\Quick@index');//展示页面
    Route::any('create','Admin\Quick@create');//添加视图
    Route::any('store','Admin\Quick@store');//执行添加
    Route::any('graph','Admin\Quick@graph');//图形展示
});
