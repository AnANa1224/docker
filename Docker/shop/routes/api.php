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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// 分类
Route::get('/category', 'ProductApi\CategoryController@show');
Route::get('/category/detail', 'ProductApi\CategoryController@find');
Route::post('/category/create', 'ProductApi\CategoryController@create');
Route::put('/category/update', 'ProductApi\CategoryController@update');
Route::delete('/category/delete', 'ProductApi\CategoryController@delete');



// 商品
Route::get('/product', 'ProductApi\ProductController@show');
Route::get('/product/detail', 'ProductApi\ProductController@find');
Route::post('/product/create', 'ProductApi\ProductController@create');
Route::put('/product/update', 'ProductApi\ProductController@update');
Route::delete('/product/delete', 'ProductApi\ProductController@delete');
// 商品Sku
Route::get('/product/sku/', 'ProductApi\ProductController@findSku');
Route::post('/product/sku/create', 'ProductApi\ProductController@createSku');
Route::put('/product/sku/update', 'ProductApi\ProductController@updateSku');
Route::delete('/product/sku/delete', 'ProductApi\ProductController@deleteSku');
Route::delete('/product/sku/attr/delete', 'ProductApi\ProductController@deleteSkuAttr');
// 商品tag
Route::get('/product/tag/', 'ProductApi\ProductController@findTag');
Route::post('/product/tag/create', 'ProductApi\ProductController@createTag');
Route::put('/product/tag/update', 'ProductApi\ProductController@updateTag');
Route::delete('/product/tag/delete', 'ProductApi\ProductController@deleteTag');



// 图片上传
Route::post('/upload/images', 'ProductApi\UploadController@images');


Route::get('/nav', 'ProductApi\Navcontroller@show');
Route::get('/nav/detail', 'ProductApi\Navcontroller@find');
Route::post('/nav/create', 'ProductApi\Navcontroller@create');
Route::put('/nav/update', 'ProductApi\Navcontroller@update');
Route::delete('/nav/delete', 'ProductApi\Navcontroller@delete');

