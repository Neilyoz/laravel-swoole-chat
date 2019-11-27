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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});
Route::post('/', 'LoginController@login')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', 'RegisterController@register');

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::post('/upload', 'UploadController@upload');

Route::get('/userinfo', 'UserController@userInfo');
Route::put('/userinfo', 'UserController@update');
Route::post('/add-friend', 'UserController@addFriend');
Route::get('/friend-list', 'UserController@friendList');
