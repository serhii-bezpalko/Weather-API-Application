<?php

use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/weather', [WeatherController::class, 'show']);
Route::post('/subscribe', [SubscriptionController::class, 'store']);
Route::get('/confirm/{token}', [SubscriptionController::class, 'confirm']);
Route::get('/unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe']);
