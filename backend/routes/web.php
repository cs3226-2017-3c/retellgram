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


Route::get('upload', 'UploadController@viewUpload');
Route::post('upload', 'UploadController@storeUpload');

Route::get('new_upload', 'UploadControllerNew@viewUpload');
Route::post('new_upload', 'UploadControllerNew@storeUpload');

//Route::post('uploadCrop', 'UploadController@cropUpload');

Route::get('new_create', 'CreateControllerNew@viewCreate');
Route::post('new_create', 'CreateControllerNew@storeCreate');

Route::get('create', 'CreateController@viewCreate');
Route::post('create', 'CreateController@storeCreate');
Route::get('selectimage', 'CreateController@viewSelectImage');
Route::post('selectimage', 'CreateController@submitSelectImage');

Route::get('detail/{id}', 'DetailController@getView');
Route::get('image/{id}', 'DetailController@getImage');
Route::get('caption', 'DetailController@getCaptions');
Route::get('caption/{id}', 'DetailController@getCaption');
Route::put('caption/{id}', 'DetailController@likeCaption');

Route::get('/', 'HomeController@home');

//Route::post('/chooseImage', 'CreateController@chooseImage');

Route::get('admin', 'AdminController@admin');