<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Controller@handle')->name('login');
Route::put('/', 'Controller@handle');
