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
Route::middleware(['auth:sanctum','active_user_api'])->group(function () {
    
    Route::post('complete-registration', 'API\RegisterController@completeRegistration')->name('registration.completion');

    Route::resource('/opportunities', 'API\OpportunityController');
    Route::post('fetch-user-opportunity-related-info', 'API\OpportunityController@fetchUserOpportunityRelatedInfo')->name('fetch.user-opportunity-related-info');
    Route::apiResource('/user-opportunities', 'API\OpportunityUserController');  
    Route::post('fetch-opportunities', 'API\OpportunityController@fetchOpportunities')->name('fetch.opportunities');
    Route::post('fetch-opportunity-users', 'API\OpportunityController@fetchOpportunityUsers')->name('fetch.opportunity-users');
    Route::post('check-enrollment', 'API\OpportunityController@checkEnrollment')->name('check-enrollment');
    Route::apiResource('/wish-list', 'User\WishListController');
    Route::apiResource('/choice-list', 'User\OpportunityUserController');


    Route::apiResource('/org-admin/opportunities', 'API\OrgAdmin\OpportunityFormController');  
    Route::apiResource('org-admin/plans', 'API\OrgAdmin\PlanController');
  

    Route::apiResource('/user/opportunities', 'API\User\OpportunityController');
    Route::apiResource('/user/rewards', 'API\User\RewardsController');    

    Route::post('/update-fcm-token', 'API\FirebaseController@updateFCMToken');  


    Route::apiResource('/notifications', 'API\NotificationController');  

    Route::apiResource('/profile', 'API\ProfileController');
    
    //thread api
    Route::get('forum/category/{category}/thread', 'API\Forum\ThreadController@recent');//all threads
    Route::post('forum/category/{category}/thread', 'API\Forum\ThreadController@store');//title, content
    Route::delete('forum/thread/{thread}', 'API\Forum\ThreadController@delete');//pass "permadelete":true if you want to delete permanently
    Route::post('forum/thread/{thread}/rename', 'API\Forum\ThreadController@rename');
    Route::post('forum/thread/{thread}/restore', 'API\Forum\ThreadController@restore');


    //post api
    Route::get('forum/thread/{thread}/posts', 'API\Forum\PostController@indexByThread');//all posts of a thread
    Route::post('forum/thread/{thread}/posts', 'API\Forum\PostController@store');// content
    Route::patch('forum/post/{post}', 'API\Forum\PostController@update');// content
    Route::delete('forum/post/{post}', 'API\Forum\PostController@delete');// "permadelete":true
    Route::post('forum/post/{post}/restore', 'API\Forum\PostController@restore');
    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });
    Route::post('logout', [RegisterController::class, 'logout']);
});