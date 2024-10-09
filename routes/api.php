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
//Route::post('/login', 'AuthController@checkLogin');
Route::group(['middleware' => 'twt-cors'], function () {
    Route::post('/login', 'AuthController@checkLogin');
    Route::get('product', 'ProductController@index');
    Route::get('product/create', 'ProductController@create');
    Route::post('product/store', 'ProductController@store');
    Route::post('product/filter', 'ProductController@filter');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
    Route::put('product/{id}', 'ProductController@update');
    Route::delete('product/{id}', 'ProductController@destroy');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

