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

// Route::middleware('auth:api')->group(function($router) {
//     // 点赞
//     $router->get('/post/is-zan/{zan_post}','\App\Api\Controllers\PostController@isZan');
// });

// Route::perfix('v1.0')->group(function(){
// 	Route::get('user/gfloor', 'UsersController@gfloor');
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    // Route::post('shopcart', 'UsersController@shopcart');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'cart'

], function ($router) {

    Route::post('shopcart', 'UsersController@shopcart');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'shop'

], function ($router) {

    Route::post('shop', 'ShopcartController@shop');
    Route::post('price', 'ShopcartController@price');
    Route::post('cartTwo1', 'ShopcartController@cartTwo1');
    Route::post('cartTwo2', 'ShopcartController@cartTwo2');
    Route::post('add', 'ShopcartController@add');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'address'

], function ($router) {

    Route::post('province', 'AddressController@province');
    Route::post('city', 'AddressController@city');
    Route::post('area', 'AddressController@area');
    Route::post('add1', 'AddressController@add1');
    Route::post('show', 'AddressController@show');


});


    Route::get('index', 'UsersController@index');
    Route::get('tree', 'UsersController@tree');
    Route::get('category', 'UsersController@category');
    Route::get('gfloor', 'UsersController@gfloor');
    Route::get('gname', 'UsersController@gname');
    Route::post('findware', 'UsersController@findware');

//     Route::group([

//     'middleware' => 'api',
//     'prefix' => 'user'

// ], function ($router) {



// });