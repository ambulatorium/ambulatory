<?php

// Inbox.
Route::get('/api/inbox', 'InboxController@index')->name('inbox');
Route::get('/api/inbox/{id}', 'InboxController@show')->name('inbox.show');

// Schedules.
Route::get('/api/schedules', 'ScheduleController@index')->name('schedules.index');
Route::get('/api/schedules/{id?}', 'ScheduleController@show')->name('schedules.show');
Route::post('/api/schedules/{id}', 'ScheduleController@store')->name('schedules.store');

// Medical Form.
Route::get('/api/medical-form', 'MedicalFormController@index')->name('medical-form.index');
Route::get('/api/medical-form/{id?}', 'MedicalFormController@show')->name('medical-form.show');
Route::post('/api/medical-form/{id}', 'MedicalFormController@store')->name('medical-form.store');

// Staff.
Route::get('/api/staff', 'StaffController@index')->name('staff.index');

// Invitations.
Route::get('/api/invitations', 'InvitationController@index')->name('invitations.index');
Route::get('/api/invitations/{id?}', 'InvitationController@show')->name('invitations.show');
Route::post('/api/invitations/{id}', 'InvitationController@store')->name('invitations.store');
Route::delete('/api/invitations/{id}', 'InvitationController@destroy')->name('invitations.destroy');

// Health Facilities.
Route::get('/api/health-facilities', 'HealthFacilityController@index')->name('health-facilities.index');
Route::get('/api/health-facilities/{id?}', 'HealthFacilityController@show')->name('health-facilities.show');
Route::post('/api/health-facilities/{id}', 'HealthFacilityController@store')->name('health-facilities.store');

// Specializations.
Route::get('/api/specializations', 'SpecializationController@index')->name('specializations.index');
Route::get('/api/specializations/{id?}', 'SpecializationController@show')->name('specializations.show');
Route::post('/api/specializations/{id}', 'SpecializationController@store')->name('specializations.store');
Route::delete('/api/specializations/{id}', 'SpecializationController@destroy')->name('specializations.destroy');

// Settings.
Route::namespace('Settings')->group(function () {
    // Account.
    Route::get('/api/account/{id}', 'AccountController@show')->name('account.show');
    Route::post('/api/account/{id}', 'AccountController@update')->name('account.update');

    // Doctor.
    Route::get('/api/doctor-profile/{id}', 'DoctorProfileController@show')->name('doctor-profile.show');
    Route::post('/api/doctor-profile/{id}', 'DoctorProfileController@store')->name('doctor-profile.store');

    // User Avatar.
    Route::post('/api/uploads-user-avatar', 'UploadUserAvatarController@create')->name('upload-user-avatar');
});

// Logout Route.
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Catch-all Route.
Route::get('/{view?}', 'AmbulatoryController')->where('view', '(.*)')->name('ambulatory');
