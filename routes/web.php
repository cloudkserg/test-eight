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

Route::get('/', 'DefaultController@index');
Route::get('/order/preview', 'OrderController@preview');
Route::get('/order/checkout', 'OrderController@showCheckout');

Route::post('/order/checkout', 'OrderController@checkout');

Route::post('/order/add', 'OrderController@add');



Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/admin', 'Auth\OrderController@index')->middleware('auth');

