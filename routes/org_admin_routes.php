<?php
Route::prefix('/org-admin')->name('org-admin.')->namespace('OrgAdmin')->group(function () {

    // Route::group(['middleware' => ['auth:org_admin', 'org-admin-guard.verified:org_admin']], function () {

    //     Route::view('/home', 'org_admin.home')->name('home');

    //     Route::resource('/opportunities', 'OpportunityController');
    // });

/**
 * Organization Admin Auth Route(s)
 */
    Route::namespace ('Auth')->group(function () {

//Organization Admin Login Routes
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');

//Organization Admin Register Routes
        Route::get('/register', 'RegisterController@showRegisterForm')->name('register');
        Route::post('/register', 'RegisterController@create');

//Organization Admin Reset Password Routes
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');

//Organization Admin Email Verification Route(s)
        Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
        Route::get('/email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
        Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');

    });

//Put all of your admin routes here...

});