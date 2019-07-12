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

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
// 显示认证邮件提醒页面
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// 处理认证成功后的业务逻辑，请注意签名认证发生在 `signed` 中间件里，
// 在 VerificationController 的 __construct 方法里做了设定
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// 重新发送用户认证邮件
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// 用户中心
Route::get('users/{user}', 'UsersController@show')->name('users.show');
Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::put('users/{user}', 'UsersController@update')->name('users.update');

// 话题
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// 和默认资源路由的topics/{topic}不一样，为了友好的url(带翻译)
Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');

// 话题分类
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// 编辑器图片上传
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
