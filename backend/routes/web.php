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
Route::post('uploadCrop', 'UploadController@cropUpload');

Route::get('create', 'CreateController@viewCreate');
Route::post('create', 'CreateController@storeCreate');
Route::get('selectimage', 'CreateController@viewSelectImage');
Route::post('selectimage', 'CreateController@submitSelectImage');

Route::get('/', 'HomeController@home');

//Route::post('/chooseImage', 'CreateController@chooseImage');

/*
	APIs
*/

Route::group(['prefix' => 'api'], function () {
  Route::get('/getCaptions', 'CaptionController@getCaptions');
  Route::get('/getImages', 'ImageController@getImages');

  Route::post('/image', 'ImageController@createImage');
  Route::get('/image/{id}', 'ImageController@getImage');
  Route::get('/image', 'ImageController@getImages');
  Route::delete('/image/{id}', 'ImageController@deleteImage');

  Route::post('/caption', 'CaptionController@createCaption');
  Route::get('/caption/{id}', 'CaptionController@getCaption');
  Route::get('/caption', 'CaptionController@getCaptionsWithQuery');
  Route::put('/caption/{id}', 'CaptionController@likeCaption');
  Route::delete('/caption/{id}', 'CaptionController@deleteCaption');
});
