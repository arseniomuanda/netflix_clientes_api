<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\PlanController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\Api\SubscribeController;
use App\Http\Controllers\API\ScreenController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);

    Route::apiResource('services', ServiceController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('subscriptions', SubscribeController::class);
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('plans', PlanController::class);
    Route::apiResource('screens', ScreenController::class);

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
});



