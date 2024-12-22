<?php

use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\Api\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PlanController;
use App\Http\Middleware\JwtMiddleware;

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
    
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('subscriontions', SubscribeController::class);
    Route::apiResource('plans', PlanController::class);
    
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
});



