<?php

use Illuminate\Support\Facades\Route;
use Pteroca\PterodactylAddon\Http\Controllers\ApiKeyController;
use Pteroca\PterodactylAddon\Http\Controllers\SSOAuthorizationController;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::prefix('/api/application')->middleware(['api', 'throttle:api.application'])->group(function () {
    Route::group(['prefix' => '/users'], function () {
        /** Api-Keys */
        Route::get('{user}/api-keys', [ApiKeyController::class, 'index']);
        Route::post('{user}/api-keys', [ApiKeyController::class, 'store']);
        Route::delete('{user}/api-keys/{identifier}', [ApiKeyController::class, 'delete']);
    });
});

Route::middleware([
    EncryptCookies::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    SubstituteBindings::class,
    // itp., ale bez VerifyCsrfToken
])->group(function () {
    Route::post('/pteroca/authorize', [SSOAuthorizationController::class, 'index']);
});
