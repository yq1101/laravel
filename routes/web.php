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

Route::get('/aa', function () {
   echo $hashed = Hash::make('bb');
});



// Route::group(['middleware' => App\Http\Middleware\CheckToken::class,], function () {
	
	Route::get('login/login', 'LoginController@login');

	Route::get('login/index', 'LoginController@index');

	Route::get('login/show', 'LoginController@show');

	Route::get('login/showa', 'LoginController@showa');

	Route::get('login/addaction', 'LoginController@addaction');

	Route::get('login/delete', 'LoginController@delete');

	Route::get('login/update', 'LoginController@update');

	Route::get('login/tuichu', 'LoginController@tuichu');
// });



// Route::get('user/index', 'UsersController@index');
// Route::get('user/category', 'UsersController@category');
// Route::get('user/tree', 'UsersController@tree');
// Route::get('user/text', 'UsersController@text');
// Route::get('user/gfloor', 'UsersController@gfloor');
// Route::get('user/gname', 'UsersController@gname');

// Route::get('hello', function () {
//     return 'Hello, Welcome to LaravelAcademy.org';
// });



// Route::match(['get', 'post'], 'foo', function () {
//     return 'This is a request from get or post';
// });

// Route::get('form',function(){
// 	return '<form method="POST" action="/blog/public/foo">'.csrf_field().'<button type="submit">提交</button></form>';
// });

// Route::redirect('/here', '/there', 301);

// Route::get('user1/{name?}', function ($name = 'John') {
//     return $name;
// });

// Route::get('user/profile', 'UsersController@showProfile')->name('profile');

// Route::get('redirect', function() {
//     // 通过路由名称进行重定向
//     return redirect()->route('profile');
// });

// Route::get('user/{id}/profile', function ($id) {
//     $url = route('profile', ['id' => $id]);
//     return $url;
// })->name('profile');

// Route::get('/todos', function(){
//     return response()->json([
//         ['id' => 1, 'title' => 'learn Vue js', 'completed' => false],
//         ['id' => 2, 'title' => 'Go to Shop', 'completed' => false],
//     ]);
// })->middleware('api');