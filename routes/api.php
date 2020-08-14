<?php

use Illuminate\Support\Facades\Route;

// Pubic routes
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome!!!',
    ]);
});

// Auth User
Route::get('me', 'User\MeController@getMe');

// Get Designs
Route::get('designs', 'Designs\DesignController@index');

// Get Users
Route::get('users', 'User\UserController@index');

// Auth Users Routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/profile', 'User\SettingsController@updateProfile');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    // Upload Designs
    Route::post('designs', 'Designs\UploadController@upload');
    Route::put('designs/{id}', 'Designs\DesignController@update');
    Route::delete('designs/{id}', 'Designs\DesignController@destroy');

});

// Guest Routes
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('reset.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset.password');
});
