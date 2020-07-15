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
