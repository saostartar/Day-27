<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/two-factor/setup', [TwoFactorController::class, 'showSetupForm'])->name('two-factor.setup');
Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::post('/user/two-factor-authentication', [UserController::class, 'enableTwoFactor'])->middleware('auth');
Route::delete('/user/two-factor-authentication', [UserController::class, 'disableTwoFactor'])->middleware('auth');
Route::get('/two-factor-challenge', [AuthenticatedSessionController::class, 'showTwoFactorForm'])->middleware('auth');
Route::post('/two-factor-challenge', [AuthenticatedSessionController::class, 'verifyTwoFactor'])->middleware('auth');
require __DIR__.'/auth.php';