<?php

use App\Http\Controllers\Api\V1\HomeSectionController;
use App\Http\Controllers\Api\V1\AboutSectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Public API endpoints for the landing page frontend.
| All endpoints are read-only (GET) and do not require authentication.
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Landing Page API v1 (Public - No Auth Required)
Route::prefix('v1')->group(function () {
    // Home Section
    Route::get('home', [HomeSectionController::class, 'index']);
    Route::get('home/{homeSection}', [HomeSectionController::class, 'show']);

    // About Section
    Route::get('about', [AboutSectionController::class, 'index']);
    Route::get('about/{aboutSection}', [AboutSectionController::class, 'show']);
});
