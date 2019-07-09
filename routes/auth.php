<?php

// Login.
Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login')->name('login.attempt');

// Register new account.
Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'RegisterController@register')->name('register.attempt');

// Forgot password.
Route::get('/password/forgot', 'ForgotPasswordController@showResetRequestForm')->name('password.forgot');
Route::post('/password/forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'ForgotPasswordController@showNewPassword')->name('password.reset');

// Accept invitation.
Route::get('/invitation/{token}', 'AcceptInvitationController@show')->name('accept.invitation');
