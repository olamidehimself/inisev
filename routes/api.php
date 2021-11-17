<?php

use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\WebsitesController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('/websites', [WebsitesController::class, 'getAllWebsites']);
    Route::post('/post/create', [WebsitesController::class, 'createPost']);
    Route::post('/website/subscribe', [SubscriptionController::class, 'subscribe']);
});
