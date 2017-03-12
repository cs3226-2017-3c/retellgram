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

Route::get('/', 'TestViewController@getTestView');

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