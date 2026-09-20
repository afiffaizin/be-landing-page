<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\HowToOrderSectionController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\TestimonialSectionController;
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
    Route::patch('/product-sections/{productSection}/toggle-status', [ProductSectionController::class, 'toggleStatus'])
        ->name('product-sections.toggle-status');
    Route::resource('product-sections', ProductSectionController::class)->except(['show']);

    // How To Order Management
    Route::patch('/how-to-orders/{howToOrder}/toggle-status', [HowToOrderSectionController::class, 'toggleStatus'])
        ->name('how-to-orders.toggle-status');
    Route::resource('how-to-orders', HowToOrderSectionController::class)->except(['show']);

    // Testimonial Hub Management
    Route::get('/testimonials', [TestimonialSectionController::class, 'index'])
        ->name('testimonials.index');
    Route::post('/testimonials/header', [TestimonialSectionController::class, 'updateHeader'])
        ->name('testimonials.update-header');
    Route::post('/testimonials/batch-store', [TestimonialSectionController::class, 'batchStore'])
        ->name('testimonials.batch-store');
    Route::put('/testimonials/items/{testimonialItem}', [TestimonialSectionController::class, 'updateItem'])
        ->name('testimonials.update-item');
    Route::delete('/testimonials/items/{testimonialItem}', [TestimonialSectionController::class, 'destroyItem'])
        ->name('testimonials.destroy-item');

    // Legacy Fallbacks & Compatibility
    Route::get('/testimonial-sections', function () {
        return redirect()->route('admin.testimonials.index');
    })->name('testimonial-sections.index');
    Route::get('/testimonial-sections/create', [TestimonialSectionController::class, 'create'])
        ->name('testimonial-sections.create');
    Route::get('/testimonial-sections/{testimonialSection}/edit', [TestimonialSectionController::class, 'edit'])
        ->name('testimonial-sections.edit');
    Route::post('/testimonial-sections', [TestimonialSectionController::class, 'store'])
        ->name('testimonial-sections.store');
    Route::put('/testimonial-sections/{testimonialSection}', [TestimonialSectionController::class, 'update'])
        ->name('testimonial-sections.update');
    Route::delete('/testimonial-sections/{testimonialSection}', [TestimonialSectionController::class, 'destroy'])
        ->name('testimonial-sections.destroy');
    Route::patch('/testimonial-sections/{testimonialSection}/toggle-status', [TestimonialSectionController::class, 'toggleStatus'])
        ->name('testimonial-sections.toggle-status');
});
