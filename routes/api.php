<?php
use App\Http\Controllers\API\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('auth/google',[RegisterController::class, 'requestTokenGoogle']);
Route::post('password/email', 'API\ForgotPasswordController@forgot');
Route::middleware('auth:sanctum')->group(function () {
    
    Route::resource('/opportunities', 'API\OpportunityController');
    Route::post('fetch-user-opportunity-related-info', 'API\OpportunityController@fetchUserOpportunityRelatedInfo')->name('fetch.user-opportunity-related-info');
    Route::apiResource('/user-opportunities', 'API\OpportunityUserController');  
    Route::post('fetch-opportunities', 'API\OpportunityController@fetchOpportunities')->name('fetch.opportunities');
    Route::post('fetch-opportunity-users', 'API\OpportunityController@fetchOpportunityUsers')->name('fetch.opportunity-users');
    Route::post('check-enrollment', 'API\OpportunityController@checkEnrollment')->name('check-enrollment');
    Route::apiResource('/wish-list', 'User\WishListController');
    Route::apiResource('/choice-list', 'User\OpportunityUserController');


    Route::apiResource('/org-admin/opportunities', 'API\OrgAdmin\OpportunityController');  
    Route::apiResource('org-admin/plans', 'API\OrgAdmin\PlanController');

    Route::apiResource('/user/opportunities', 'API\User\OpportunityController');  

    Route::post('/update-fcm-token', 'API\FirebaseController@updateFCMToken');  


    Route::apiResource('/notifications', 'API\NotificationController');  

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('logout', [RegisterController::class, 'logout']);
});