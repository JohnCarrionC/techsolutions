<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialiteController;

// Redirección de la raíz al login o dashboard según el estado de sesión
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Rutas de Autenticación Tradicional
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Registro de Usuarios
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rutas de GitHub Socialite
Route::get('/auth/github', [SocialiteController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [SocialiteController::class, 'handleGithubCallback']);

// Panel Protegido por Middleware de Autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});