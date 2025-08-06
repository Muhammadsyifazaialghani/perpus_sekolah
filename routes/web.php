<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// User login routes
Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
Route::post('/login', [AuthController::class, 'userLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User register routes
Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
Route::post('/register', [AuthController::class, 'userRegister'])->name('register.post');

// Admin login routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('filament.admin.auth.logout');

// Filament admin logout route to fix RouteNotFoundException
// Removed duplicate route to avoid redundancy

// Admin register routes
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('admin.register.post');

// User dashboard route
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Admin dashboard route - ensure admin role
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return redirect('/admin');
    })->name('admin.dashboard');
});
