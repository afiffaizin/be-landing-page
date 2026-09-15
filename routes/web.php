<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Custom Admin Portal & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin Panel Routes (Protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Home Section Management
    Route::patch('/home-sections/{homeSection}/toggle-status', [HomeSectionController::class, 'toggleStatus'])
        ->name('home-sections.toggle-status');
    Route::resource('home-sections', HomeSectionController::class)->except(['show']);

    // About Section Management
    Route::patch('/about-sections/{aboutSection}/toggle-status', [AboutSectionController::class, 'toggleStatus'])
        ->name('about-sections.toggle-status');
    Route::resource('about-sections', AboutSectionController::class)->except(['show']);

    // Product Section Management
    Route::patch('/product-sections/{productSection}/toggle-status', [\App\Http\Controllers\Admin\ProductSectionController::class, 'toggleStatus'])
        ->name('product-sections.toggle-status');
    Route::resource('product-sections', \App\Http\Controllers\Admin\ProductSectionController::class)->except(['show']);
});
