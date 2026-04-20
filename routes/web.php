<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/services', [ServiceController::class, 'index'])->name('services');

// Client Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
    
    // Booking creation - only for non-admin users
    Route::middleware('not.admin')->group(function () {
        Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::delete('/booking/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');
        Route::post('/review/{appointment}', [BookingController::class, 'submitReview'])->name('review.submit');
    });
});

//Portfolio routes
Route::post('/portfolio/{portfolio}/favorite', [PortfolioController::class, 'toggleFavorite'])
    ->name('portfolio.favorite')
    ->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/appointments/{appointment}/status', [DashboardController::class, 'updateStatus'])->name('appointments.status');
    Route::get('/content/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/update', [ContentController::class, 'update'])->name('content.update');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::patch('/reviews/{review}/toggle', [ReviewController::class, 'toggleFeatured'])->name('reviews.toggle');
    Route::get('/portfolio', [AdminPortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/create', [AdminPortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [AdminPortfolioController::class, 'store'])->name('portfolio.store');
    Route::put('/portfolio/{portfolio}', [AdminPortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [AdminPortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::patch('/portfolio/{portfolio}/toggle', [AdminPortfolioController::class, 'toggleBefore'])->name('portfolio.toggle');
    Route::post('/portfolio/link-pair', [AdminPortfolioController::class, 'linkPair'])->name('portfolio.link-pair');
    Route::get('/services/{service}', [AdminServiceController::class, 'show'])->name('services.show');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
});



require __DIR__.'/auth.php';