<?php

// Medical Form.
Route::get('/api/medical-form' , 'MedicalFormController@index')->name('medical-form.index');
Route::get('/api/medical-form/{id?}', 'MedicalFormController@show')->name('medical-form.show');
Route::post('/api/medical-form/{id}', 'MedicalFormController@store')->name('medical-form.store');
Route::delete('/api/medical-form/{id}', 'MedicalFormController@destroy')->name('medical-form.destroy');

Route::get('/api/working-hours' , 'WorkingHoursController@index')->name('working-hours.index');
Route::get('/api/working-hours/{id?}', 'WorkingHoursController@show')->name('working-hours.show');
Route::post('/api/working-hours/{id}', 'WorkingHoursController@store')->name('working-hours.store');

// Specialities.
Route::get('/api/specialities' , 'SpecialityController@index')->name('specialities.index');
Route::get('/api/specialities/{id?}', 'SpecialityController@show')->name('specialities.show');
Route::post('/api/specialities/{id}', 'SpecialityController@store')->name('specialities.store');
Route::delete('/api/specialities/{id}', 'SpecialityController@destroy')->name('specialities.destroy');

// Staff.
Route::get('/api/staff', 'StaffController@index')->name('staff.index');

// Locations.
Route::get('/api/healthcare-locations' , 'HealthcareLocationController@index')->name('locations.index');
Route::get('/api/healthcare-locations/{id?}', 'HealthcareLocationController@show')->name('locations.show');
Route::post('/api/healthcare-locations/{id}', 'HealthcareLocationController@store')->name('locations.store');
Route::delete('/api/healthcare-locations/{id}', 'HealthcareLocationController@destroy')->name('locations.destroy');

// Invitations.
Route::get('/api/invitations' , 'InvitationController@index')->name('invitations.index');
Route::get('/api/invitations/{id?}' , 'InvitationController@show')->name('invitations.show');
Route::post('/api/invitations/{id}', 'InvitationController@store')->name('invitations.store');
Route::delete('/api/invitations/{id}', 'InvitationController@destroy')->name('invitations.destroy');

// Settings.
Route::namespace('Settings')->group(function () {
    // Account
    Route::get('/api/account/{id}', 'AccountController@show')->name('account.show');
    Route::post('/api/account/{id}', 'AccountController@update')->name('account.update');

    // Doctor
    Route::get('/api/doctor-profile/{id}', 'DoctorProfileController@show')->name('doctor-profile.show');
    Route::post('/api/doctor-profile/{id}', 'DoctorProfileController@store')->name('doctor-profile.store');

    // Avatar
    Route::post('/api/uploads-user-avatar', 'UploadUserAvatarController@create')->name('upload-user-avatar');
});

// Logout Route.
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Catch-all Route.
Route::get('/{view?}', 'ReliquiController')->where('view', '(.*)')->name('reliqui');