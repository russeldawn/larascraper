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

Route::get('/', 'ScraperController@create')->name('home');
Route::post('/scraper', 'ScraperController@store');

// Route::get('/child', 'UserController@child');
// Route::get('/parent', 'UserController@child');
