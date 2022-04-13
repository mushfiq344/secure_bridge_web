<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth','active_user','is_user'], "namespace" => "User"], function () {

    Route::prefix('/user')->name('user.')->group(function () {
        Route::apiResource('/choice-list', 'OpportunityUserController');
        Route::apiResource('/wish-list', 'WishListController');
        Route::resource('/opportunities', 'OpportunityController');
        Route::resource('/profiles', 'ProfileController');
        Route::get('/home', 'OpportunityController@index')->name('home');

    });

});

// Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

/*
    admin routes starts
*/
Route::group([ 'namespace' => 'Admin', 'middleware' => [ 'auth','is_admin']], function () {
    // routes for registrations
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/home', "HomeController@index")->name('home');
        Route::resource('users', "UsersController");
        Route::post('search-users', "UsersController@searchUsers")->name('search-users');
        Route::resource('plans', "PlanController");
        Route::resource('opportunities', "OpportunitiesController");
        Route::post('change-opportunity-feature-status', "OpportunitiesController@changeOpportunityFeatureStatus")->name('change-opportunity-feature-status');
        Route::post('change-user-status', "UsersController@changeUserStatus")->name('admin-change-user-status');
        // Route::resource('mails', "MailController");

        // Route::resource('blogs', "BlogsController");

        // Route::resource('settings', "SettingsController");

        // Route::resource('social-links', "SocialLinkController");
    });
});
/*
    admin routes ends
*/


Route::prefix('/org-admin')->name('org-admin.')->group(function () {

    Route::group(['middleware' => ['auth', 'active_user','is_org_admin'], "namespace" => "OrgAdmin"], function () {
        Route::apiResource('/user-opportunities', 'OpportunityUserController');  
        Route::view('/home', 'org_admin.home')->name('home');
        Route::resource('/opportunities', 'OpportunityController');
        Route::resource('/profiles', 'ProfileController');

    });

    Route::get('/login', 'Auth\LoginController@showOrgAdminLoginForm')->name('login');

    Route::get('/register', 'Auth\RegisterController@showOrgAdminRegisterForm')->name('register');
    Route::post('/register', 'Auth\RegisterController@CreateOrgAdmin');

});
Route::group(['middleware' => ['auth','active_user']], function () {
    Route::post('fetch-opportunities', 'OpportunityController@fetchOpportunities')->name('fetch.opportunities');

    Route::get('/chatting/{id?}', "MessagesController@index")->where('id', '[0-9]*');
    Route::get('/message/{id}', 'MessagesController@getMessage')->name('message');
    Route::get('/message-list', 'MessagesController@getMessageList')->name('message.list');
    Route::post('message', 'MessagesController@sendMessage');

    Route::post('message-users', 'MessagesController@loadUsers')->name('load.users');
});

Route::get('/send-notification', 'API\FirebaseController@notification')->name('notification.send');


Route::post('webhook-custom/stripe', 'CustomStripeWebHookController@handleWebhook');

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

