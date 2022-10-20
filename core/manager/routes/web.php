<?php

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
//Route::group(['web'], fn()=> Route::any('/', 'HomeController@process')->name('login'));
//Route::any('/', 'HomeController@process')->name('login');

//Route::any('/', function () {
//    if (\Illuminate\Support\Facades\Auth::check()) {
//        return app()->version();
//    } else {
//        return csrf_token();
//    }
//    //return csrf_token();
//})->name('login');

Route::any('/', 'LoginController@test')->name('login');

//Route::any('/', 'HomeController@handle');

Route::post('/', 'Controller@process');
