<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - BuzzBazaar Marketplace
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [ListingController::class, 'home'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Mandatory Required Routes
Route::get('/category/{category:slug}', [ListingController::class, 'category'])->name('listings.category');
Route::get('/city/{city}', [ListingController::class, 'city'])->name('listings.city');
Route::get('/city/{city}/category/{category:slug}', [ListingController::class, 'cityCategory'])->name('listings.city_category');
Route::get('/listing/{listing}', [ListingController::class, 'show'])->name('listings.show');

// Dynamic AJAX routes
Route::get('/api/categories/{category}/subcategories', [ListingController::class, 'getSubcategories'])->name('api.subcategories');
Route::get('/api/locations/states', [ListingController::class, 'getStates'])->name('api.locations.states');
Route::get('/api/locations/cities', [ListingController::class, 'getCities'])->name('api.locations.cities');

// Authentication Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/post-ad', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/my-listings', [ListingController::class, 'myListings'])->name('listings.my');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
});
