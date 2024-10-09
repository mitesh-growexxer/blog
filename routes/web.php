<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'AuthController@login')->name('login');
    Route::get('/', 'AuthController@login')->name('login');
    Route::get('', 'AuthController@login')->name('home');
    Route::post('/login', 'AuthController@checkLogin');
    Route::get('register', 'AuthController@register')->name('register');
    Route::post('/register', 'AuthController@registerPost');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::delete('/logout', 'AuthController@logout')->name('logout');
    Route::get('product', 'ProductController@index');
    Route::get('product/create', 'ProductController@create');
    Route::post('product/store', 'ProductController@store');
    Route::post('product/filter', 'ProductController@filter');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
    Route::put('product/{id}', 'ProductController@update');
    Route::delete('product/{id}', 'ProductController@destroy');

    Route::get('order', 'OrderController@index');
    Route::post('order/filter', 'OrderController@filter');
});