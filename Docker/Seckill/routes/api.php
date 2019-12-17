<?php

use Illuminate\Http\Request;

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

// 商品
Route::get('/product', 'ProductController@find');
Route::post('/product/create', 'ProductController@create');

// 订单
Route::get('/order/find', 'OrderController@find');
Route::post('/order/create', 'OrderController@create');
Route::post('/order/add', 'OrderController@add');
Route::delete('/order/cancel', 'OrderController@cancel'); #取消订单
Route::delete('/order/delete', 'OrderController@delete'); #删除订单
