<?php

// Inbox.
Route::get('/api/inbox', 'InboxController@index')->name('inbox');
Route::get('/api/inbox/{id}', 'InboxController@show')->name('inbox.show');

// Schedules.
Route::get('/api/schedules', 'ScheduleController@index')->name('schedules');
Route::post('/api/schedules', 'ScheduleController@store')->name('schedules.store');
Route::get('/api/schedules/{schedule}', 'ScheduleController@show')->name('schedules.show');
Route::patch('/api/schedules/{schedule}', 'ScheduleController@update')->name('schedules.update');

// Medical Forms.
Route::get('/api/medical-forms', 'MedicalFormController@index')->name('medical-forms');
Route::post('/api/medical-forms', 'MedicalFormController@store')->name('medical-forms.store');
Route::get('/api/medical-forms/{medicalForm}', 'MedicalFormController@show')->name('medical-forms.show');
Route::patch('/api/medical-forms/{medicalForm}', 'MedicalFormController@update')->name('medical-forms.update');

// Staff.
Route::get('/api/staff', 'StaffController@index')->name('staff.index');

// Invitations.
Route::get('/api/invitations', 'InvitationController@index')->name('invitations');
Route::post('/api/invitations', 'InvitationController@store')->name('invitations.store');
Route::get('/api/invitations/{invitation}', 'InvitationController@show')->name('invitations.show');
Route::patch('/api/invitations/{invitation}', 'InvitationController@update')->name('invitations.update');
Route::delete('/api/invitations/{invitation}', 'InvitationController@destroy')->name('invitations.destroy');

// Health Facilities.
Route::get('/api/health-facilities', 'HealthFacilityController@index')->name('health-facilities');
Route::post('/api/health-facilities', 'HealthFacilityController@store')->name('health-facilities.store');
Route::get('/api/health-facilities/{healthFacility}', 'HealthFacilityController@show')->name('health-facilities.show');
Route::patch('/api/health-facilities/{healthFacility}', 'HealthFacilityController@update')->name('health-facilities.update');

// Specializations.
Route::get('/api/specializations', 'SpecializationController@index')->name('specializations.index');
Route::get('/api/specializations/{id}', 'SpecializationController@show')->name('specializations.show');
Route::post('/api/specializations/{id}', 'SpecializationController@store')->name('specializations.store');
Route::delete('/api/specializations/{id}', 'SpecializationController@destroy')->name('specializations.destroy');

// Settings.
Route::namespace('Settings')->group(function () {
    // Account.
    Route::get('/api/account/{id}', 'AccountController@show')->name('account.show');
    Route::post('/api/account/{id}', 'AccountController@update')->name('account.update');

    // Doctor profile.
    Route::get('/api/doctor-profile', 'DoctorProfileController@show')->name('doctor-profile.show');
    Route::post('/api/doctor-profile', 'DoctorProfileController@store')->name('doctor-profile.store');
    Route::patch('/api/doctor-profile', 'DoctorProfileController@update')->name('doctor-profile.update');

    // User Avatar.
    Route::post('/api/uploads-user-avatar', 'UploadUserAvatarController@create')->name('upload-user-avatar');

    // New password.
    Route::post('/api/password/new', 'NewPasswordController@update')->name('new-password');
});

// Logout Route.
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Catch-all Route.
Route::get('/{view?}', 'AmbulatoryController')->where('view', '(.*)')->name('ambulatory');
