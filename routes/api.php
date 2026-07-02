<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sync/push', [\App\Http\Controllers\Api\SyncController::class, 'push']);
Route::get('/sync/pull', [\App\Http\Controllers\Api\SyncController::class, 'pull']);
Route::post('/sync/verify-login', [\App\Http\Controllers\Api\SyncController::class, 'verifyLogin']);
