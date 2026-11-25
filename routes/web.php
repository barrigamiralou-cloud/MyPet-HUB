<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest-only pages (a logged-in user is redirected to the dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::view('/', 'welcome')->name('welcome');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated pages (a guest is redirected to the login page)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::post('/pets', [DashboardController::class, 'storePet'])->name('pets.store');
    Route::delete('/pets/{pet}', [DashboardController::class, 'destroyPet'])->name('pets.destroy');

    Route::post('/businesses', [DashboardController::class, 'storeBusiness'])->name('businesses.store');
    Route::patch('/businesses/{business}/toggle', [DashboardController::class, 'toggleBusiness'])->name('businesses.toggle');
});
