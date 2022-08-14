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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * @Desc: Upload new file
 * @URL: public/file-upload
 * @Permission: Auth
 * @Parameters: file
 * @method: POST
 */
Route::post('file-upload', 'HomeController@fileUpload')->name('file.upload.post');

/**
 * @Desc: get all files for user 
 * @URL: public/encrypted-page
 * @Permission: Auth
 * @Parameters:
 * @method: get
 */
Route::get('encrypted-page', 'HomeController@fileEncrypted')->name('file.encrypted.get');

/**
 * @Desc: decrypt file by id
 * @URL:decrypt/{file_id}
 * @Permission: Auth
 * @Parameters:
 * @method: get
 */
Route::get('decrypt/{file_id}', 'HomeController@decrypt')->name('file.decrypt');

/**
 * @Desc: encrypt file by id
 * @URL: public/encrypt/{file_id}
 * @Permission: Auth
 * @Parameters:
 * @method: get
 */
Route::get('encrypt/{file_id}', 'HomeController@encrypt')->name('file.encrypt');

/**
 * @Desc: download file by id
 * @URL: public/download/{code/file_id}
 * @Permission: Auth
 * @Parameters:
 * @method: get
 */
Route::get('download/{code}/{file_id}', 'HomeController@fileDownload');


