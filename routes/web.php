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

Route::get('/', 'ProductController@products');
Route::get('/products', 'ProductController@products');
Route::get('/create-product', 'ProductController@create');
Route::post('/create-product', 'ProductController@create');

Route::get('/edit-product/{id}', 'ProductController@edit');
Route::post('/edit-product/{id?}', 'ProductController@edit');

Route::get('/product/{id}', 'ProductController@view');

Route::get('/delete/{id}', 'ProductController@delete');


