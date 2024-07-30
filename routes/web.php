<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@checkLogin');
    Route::get('register', 'AuthController@register')->name('register');
    Route::post('/register', 'AuthController@registerPost');
});

//Route::group(['middleware' => 'auth'], function () {
    //Route::get('dashboard', 'aController@index');
    Route::post('/logout', 'AuthController@logout')->name('logout');
    Route::get('product', 'ProductController@index');
    Route::get('product/create', 'ProductController@create');
    Route::post('product/store', 'ProductController@store');
//});