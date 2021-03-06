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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'PagesController@root')->name('root');

//Auth::routes();
// Authentication Routes ...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgetPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/email', 'Auth\ForgetPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Users
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']] );
// Topics
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

// Categories
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

//富文本上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

// 回复
Route::resource('replies', 'RepliesController', ['only' => [ 'store', 'destroy']]);

// 通知
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

// 无权访问
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');