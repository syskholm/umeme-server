<?php

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->middleware('guest')->group(function () {
        Route::post('login', 'AuthController@index');
        Route::post('customer/register', 'CustomerController@store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/test', function () {
            return response()->json(['message' => 'test-endpoint']);
        });

        Route::prefix('user')->group(function () {
            Route::post('register', 'UserController@store');
        });
    });
});
