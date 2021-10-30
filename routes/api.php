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


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/opportunities', 'Api\OpportunityController');
    Route::post('fetch-opportunities', 'Api\OpportunityController@fetchOpportunities')->name('fetch.opportunities');
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('logout', [RegisterController::class, 'logout']);
});