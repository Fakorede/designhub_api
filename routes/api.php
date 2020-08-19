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
Route::get('designs/{id}', 'Designs\DesignController@findDesign');

// Get Users
Route::get('users', 'User\UserController@index');

// Get Teams
Route::get('teams/slug/{slug}', 'Teams\TeamsController@findBySlug');

// Auth Users Routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/profile', 'User\SettingsController@updateProfile');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    // Upload Designs
    Route::post('designs', 'Designs\UploadController@upload');
    Route::put('designs/{id}', 'Designs\DesignController@update');
    Route::delete('designs/{id}', 'Designs\DesignController@destroy');

    // Comments
    Route::post('designs/{id}/comment', 'Designs\CommentController@store');
    Route::put('comments/{id}', 'Designs\CommentController@update');
    Route::delete('comments/{id}', 'Designs\CommentController@destroy');

    // Likes & Unlikes
    Route::post('designs/{id}/like', 'Designs\DesignController@like');
    Route::get('designs/{id}/liked', 'Designs\DesignController@checkIfUserHasLiked');

    // Teams
    Route::post('teams', 'Teams\TeamsController@store');
    Route::get('teams/{slug}', 'Teams\TeamsController@findBySlug');
    Route::get('teams/{id}', 'Teams\TeamsController@findById');
    Route::get('teams', 'Teams\TeamsController@index');
    Route::get('user/teams', 'Teams\TeamsController@fetchUserTeams');
    Route::put('teams/{id}', 'Teams\TeamsController@update');
    Route::delete('teams/{id}', 'Teams\TeamsController@destroy');
    Route::delete('teams/{id}/users/{userId}', 'Teams\TeamsController@removeFromTeam');

    // Invitations
    Route::post('invitations/{teamId}', 'Teams\InvitationsController@invite');
    Route::post('invitations/{id}/resend', 'Teams\InvitationsController@resend');
    Route::post('invitations/{id}/respond', 'Teams\InvitationsController@respond');
    Route::delete('invitations/{id}', 'Teams\InvitationsController@destroy');
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
