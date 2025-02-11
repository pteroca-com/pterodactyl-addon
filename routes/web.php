<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Pteroca\PterodactylAddon\Http\Controllers\ApiKeyController;
use Pteroca\PterodactylAddon\Http\Controllers\SSOAuthorizationController;

Route::prefix('/api/application')->middleware(['api', 'throttle:api.application'])->group(function () {
    Route::group(['prefix' => '/users'], function () {
        /** Api-Keys */
        Route::get('{user}/api-keys', [ApiKeyController::class, 'index']);
        Route::post('{user}/api-keys', [ApiKeyController::class, 'store']);
        Route::delete('{user}/api-keys/{identifier}', [ApiKeyController::class, 'delete']);
    });
});

Route::middleware(['web'])->group(function () {
    Route::get('/pteroca/authorize', [SSOAuthorizationController::class, 'index']);
});
