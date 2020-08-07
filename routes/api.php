<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome!!!',
    ]);
});

// Users routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
});

// Guest routes
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::post('login', 'Auth\LoginController@login');
});
