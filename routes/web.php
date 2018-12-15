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

Route::group(['middleware' => 'web'], function () {

    Route::get('/login','LoginController@getLogin')->name('login');
    Route::post('/login','LoginController@postLogin');
    Route::get('/logout','LoginController@logout');

    Route::get('/','AppController@home');
    Route::get('/inventory','AppController@getInventory');
    Route::get('/inventory-add-product','AppController@getAddProduct');
    Route::post('/inventory-add-product','AppController@postAddProduct');

    Route::get('/place-order','AppController@getPlaceOrder');
    Route::post('/place-order','AppController@postPlaceOrder');

    Route::get('get-product-list','AppController@getProductList');

    Route::get('/orders','AppController@getOrders');
    Route::get('/order/{id}','AppController@showOrder');

    
    Route::get('/sales-report','AppController@showSalesReport');
    
    Route::get('orders-json','AppController@getOrdersJson');
});
