<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:auth')->prefix('auth')->group(function (): void {
    Route::post('login', [AuthController::class, 'login'])->name('api.v1.login');
});
