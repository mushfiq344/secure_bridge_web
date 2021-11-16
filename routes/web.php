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

Route::group(['middleware' => ['auth', 'is_user'], "namespace" => "User"], function () {

    Route::prefix('/user')->name('user.')->group(function () {
        Route::apiResource('/choice-list', 'OpportunityUserController');
        Route::apiResource('/wish-list', 'WishListController');
        Route::resource('/opportunities', 'OpportunityController');
        Route::resource('/profiles', 'ProfileController');
        Route::get('/home', 'OpportunityController@index')->name('home');

    });

});

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::prefix('/org-admin')->name('org-admin.')->group(function () {

    Route::group(['middleware' => ['auth', 'is_org_admin'], "namespace" => "OrgAdmin"], function () {
        Route::apiResource('/user-opportunities', 'OpportunityUserController');  
        Route::view('/home', 'org_admin.home')->name('home');
        Route::resource('/opportunities', 'OpportunityController');
        Route::resource('/profiles', 'ProfileController');

    });

    Route::get('/login', 'Auth\LoginController@showOrgAdminLoginForm')->name('login');

    Route::get('/register', 'Auth\RegisterController@showOrgAdminRegisterForm')->name('register');
    Route::post('/register', 'Auth\RegisterController@CreateOrgAdmin');

});
Route::group(['middleware' => ['auth']], function () {
    Route::post('fetch-opportunities', 'OpportunityController@fetchOpportunities')->name('fetch.opportunities');

    Route::get('/chatting/{id?}', "MessagesController@index")->where('id', '[0-9]*');
    Route::get('/message/{id}', 'MessagesController@getMessage')->name('message');
    Route::get('/message-list', 'MessagesController@getMessageList')->name('message.list');
    Route::post('message', 'MessagesController@sendMessage');

    Route::post('message-users', 'MessagesController@loadUsers')->name('load.users');
});
