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
// If user requests the home page
Route::get('/', 		'HomeController@index');

Route::get('contact', 	'ContactController@index');

Route::get('about', 	'AboutController@index');

Route::resource('shop', 'ShopController');


Auth::routes();

Route::resource('account', 'AccountController');

Route::resource('blog', 'BlogController');
Route::post('blog/newcomment','BlogController@newComment');
