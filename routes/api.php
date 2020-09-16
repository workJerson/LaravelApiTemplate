<?php

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

Route::group(
    ['prefix' => 'auth', 'namespace' => 'App\Http\Controllers'],
    function () {
        Route::post('login', 'AuthController@login');
    }
);
Route::group(
    ['middleware' => 'auth:api'],
    function () {
        // Routes Here
    }
);
