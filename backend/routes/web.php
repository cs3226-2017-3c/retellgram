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

/*
	Routes
*/

Route::get('snap', 'UploadControllerNew@viewUpload');
Route::post('snap', 'UploadControllerNew@storeUpload');

Route::get('search', 'SearchController@showResult');

Route::get('tell', 'CreateControllerNew@viewCreate');
Route::post('tell', 'CreateControllerNew@storeCreate');


Route::get('detail/{id}', 'DetailController@getView');
Route::get('image/{id}', 'DetailController@getImage');
Route::get('caption', 'DetailController@getCaptions');
Route::get('caption/{id}', 'DetailController@getCaption');
Route::put('caption/{id}', 'DetailController@likeCaption');

Route::post('image/{id}/delete', 'AdminController@deleteImage');
Route::put('image/{id}', 'UploadControllerNew@reportImage');

Route::get('newlikes', 'CharacterNewLikeController@getAll');

Route::get('home', 'HomeController@home');
Route::get('/', 'HomeController@home');

Route::get('thisrouteshouldhidefromuseradmin', 'AdminController@admin');
Route::get('thisrouteshouldhidefromuseradmin/{id}', 'AdminController@adminCaption');
Route::get('thisrouteshouldhidefromuserreport', 'AdminController@adminReport');
Route::post('caption/{id}/delete', 'AdminController@deleteCaption');
Route::post('image/{id}/resetReports', 'AdminController@resetImageReport'); 


// Authentication Routes...
Route::get('thisrouteshouldhidefromuserlogin', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('thisrouteshouldhidefromuserlogin', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', function () {  abort('404');})->name('password.request');
Route::post('password/email', function () { abort('404');})->name('password.email');
Route::get('password/reset/{token}', function () { abort('404');})->name('password.reset');
Route::post('password/reset', function () { abort('404');});
