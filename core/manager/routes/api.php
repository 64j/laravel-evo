<?php

use Illuminate\Support\Facades\Route;

Route::post('/', 'Controller@handle')->middleware(['auth:api']);
