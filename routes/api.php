<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login/', [AuthController::class, 'login']);
Route::post('/register/', [AuthController::class, 'register']);

Route::group([
    'middleware' => 'api',
], function ($router) {

    Route::post('/logout/', [AuthController::class, 'logout']);
    Route::post('/refresh/', [AuthController::class, 'refresh']);
    Route::post('/me/', [AuthController::class, 'me']);

    //services
    Route::get('/services/', [ServicesController::class, 'index']);
    Route::get('/services/{id}/', [ServicesController::class, 'watch']);
    Route::post('/services/', [ServicesController::class, 'register']);
    Route::put('/services/{id}/', [ServicesController::class, 'update']);
    Route::delete('/services/{id}/', [ServicesController::class, 'delete']);

    //entities
    Route::get('/entities/all/{id}/', [EntitiesController::class, 'index']);
    Route::get('/entities/{id}/', [EntitiesController::class, 'watch']);
    Route::post('/entities/', [EntitiesController::class, 'register']);
    Route::post('/entities/{id}/', [EntitiesController::class, 'update']);
    Route::delete('/entities/{id}/', [EntitiesController::class, 'delete']);

    //quotes
    Route::get('/quotes/all/{id}/', [QuotesController::class, 'index']);
    Route::get('/quotes/{id}/', [QuotesController::class, 'watch']);
    Route::post('/quotes/', [QuotesController::class, 'register']);
    Route::put('/quotes/{id}/', [QuotesController::class, 'update']);
    Route::delete('/quotes/{id}/', [QuotesController::class, 'delete']);

    //dashboard
    Route::get('/dashboard/', [DashboardController::class, 'index']);

    //users
    Route::get('/users/', [UserController::class, 'index']);
    Route::get('/users/{id}/', [UserController::class, 'watch']);
    Route::put('/users/{id}/', [UserController::class, 'update']);
    Route::delete('/users/{id}/', [UserController::class, 'delete']);

});
