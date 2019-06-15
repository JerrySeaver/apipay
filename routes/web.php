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
Route::get('/Login','LoginController@login');


Route::get('/text/curlone','Text\TextController@curlOne');//测试curlGET请求

Route::get('/text/curltwo','Text\TextController@curlTwo');//测试curlWechat的Access_token

Route::post('/text/curlThree','Text\TextController@curlThree');//测试curlget请求数组

Route::post('/text/FormData','Text\TextController@FormData');//测试FormData

Route::post('/text/WwwXFormUrlencoded','Text\TextController@WwwXFormUrlencoded');//测试WwwXFormUrlencoded

Route::post('/text/Raw','Text\TextController@Raw');//测试Raw

Route::get('/text/zttp','Text\TextController@zttp');//zttp

Route::post('/upload','Text\TextController@upload');//zttp

Route::get('/encode','Text\TextController@encode');//加密

Route::get('/encodeTwo','Text\TextController@encodeTwo');//AES加密

Route::get('/asymmetric','Text\TextController@asymmetric');//AES非对称加密

Route::get('/testEncode','Text\TextController@testEncode');//AES非对称加密

Route::post('/testDeasy','Text\TextController@testDeasy');//AES对称解密

Route::any('/alipayView','Text\TextController@aliPayView');//AES对称解密

Route::any('/alipay','Text\TextController@aliPay');//AES对称解密