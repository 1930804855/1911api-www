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

/**
 * 微信access_token 路由
 */
Route::get('/wx/token','IndexController@getToken');
/**
 * curl获取access_token路由
 */
Route::get('/wx/curltoken','IndexController@getCurlToken');
/**
 * 使用Guzzle获取access_token
 */
Route::get('/wx/gtoken','IndexController@getGuzzleToken');



/**
 * laravel自带获取随机字符串 用于接口返回
 */
Route::get('token','IndexController@testToken');


/**
 * www项目调用api项目测试路由
 */
Route::get('test','IndexController@test');

/**
 * api项目调用本项目测试
 */
Route::get('user/info','IndexController@userinfo');

/**
 * 数据加密练习路由
 */
Route::prefix('test')->group(function(){
    //对称加密
    Route::get('enc','TestController@enc');
    //非对称加密
    Route::get('pubenc','TestController@pubenc');
    //对向加密路由
    Route::get('encs','TestController@encs');
    //MD5()签名 验签 加密
    Route::get('sign1','TestController@sign1');
    //使用私钥生成签名
    Route::get('privsign','TestController@privsign');
    //数据对称加密+私钥加密签名路由
    Route::get('datasign','TestController@dataSign');
    //使用header传值
    Route::get('header1','TestController@header1');
    //支付页面
    Route::get('payview','TestController@payview');
    //支付
    Route::get('pay','TestController@pay');
});

/**
 * 商店模块 项目
 */
Route::prefix('mstore')->group(function(){
    //前台首页
    Route::get('/','Mstore\IndexController@index');
    //登录页面
    Route::get('login','Mstore\LoginController@login');
    //执行登录
    Route::post('loginDo','Mstore\LoginController@loginDo');
    //注册页面
    Route::get('register','Mstore\LoginController@register');
    //执行注册
    Route::post('registerDo','Mstore\LoginController@registerDo');
});

/**
 * GitHub第三方登录测试
 */
Route::get('oauth/github','OauthController@github');