<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('search', [\App\Http\Controllers\UserController::class, 'search']);

Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);

Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
