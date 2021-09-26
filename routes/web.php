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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::prefix('/org-admin')->name('org-admin.')->group(function () {

    Route::group(['middleware' => ['auth', 'is_org_admin'], "namespace" => "OrgAdmin"], function () {

        Route::view('/home', 'org_admin.home')->name('home');

        Route::resource('/opportunities', 'OpportunityController');
    });

    Route::get('/login', 'Auth\LoginController@showOrgAdminLoginForm')->name('login');

    Route::get('/register', 'Auth\RegisterController@showOrgAdminRegisterForm')->name('register');
    Route::post('/register', 'Auth\RegisterController@CreateOrgAdmin');

});