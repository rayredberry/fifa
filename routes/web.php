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

//Route::get('/', function () {
//    return redirect()->action('MatchController@index')->name('index');
//});


Route::get('/')->uses('MatchController@index')->name('index');



Route::get('/user/{id}', 'HomeController@user')->name('profile');
Route::get('/deleteMatch/{id}', 'MatchController@delete')->name('delete');



Route::post('/addMatch')->uses('MatchController@addMatch')->name('index');
Route::get('/list')->uses('HomeController@list')->name('index');
Route::get('/store')->uses('MatchController@store')->name('store');
Route::get('/storeUser')->uses('HomeController@addUsers')->name('storeUsers');




