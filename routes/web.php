<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/return/book', [App\Http\Controllers\UserDashboardController::class, 'returnBookForm'])->name('return.book');    

// Login options page
Route::get('/login', function () {
    return view('auth.login-options');
})->name('login');

// User login routes
Route::get('/user/login', [AuthController::class, 'showUserLogin'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'userLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// User register routes
Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
Route::post('/register', [AuthController::class, 'userRegister'])->name('register.post');

// Admin login routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->middleware('auth')->name('filament.admin.auth.logout');

// Filament admin logout route to fix RouteNotFoundException
// Removed duplicate route to avoid redundancy

// Admin register routes
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('admin.register.post');

// Public dashboard route - accessible without login
Route::get('/books', [UserDashboardController::class, 'publicIndex'])->name('public.dashboard');
Route::get('/books/search', [UserDashboardController::class, 'publicSearch'])->name('public.dashboard.search');
Route::get('/books/{id}', [UserDashboardController::class, 'publicShowBook'])->name('public.book.detail');

// User dashboard route - requires login
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [UserDashboardController::class, 'searchBooks'])->name('dashboard.search');
    Route::get('/dashboard/book/{id}', [UserDashboardController::class, 'showBook'])->name('dashboard.book.detail');
    Route::get('/dashboard/book/{id}/borrow', [UserDashboardController::class, 'borrowForm'])->name('dashboard.book.borrow.form');
    Route::post('/dashboard/book/{id}/borrow', [UserDashboardController::class, 'confirmBorrow'])->name('dashboard.book.borrow.confirm');

    // Route untuk riwayat peminjaman
    Route::get('/dashboard/borrow-history', [UserDashboardController::class, 'borrowHistory'])->name('dashboard.borrow.history');

    // Route untuk daftar kategori
    Route::get('/dashboard/categories', [UserDashboardController::class, 'listCategories'])->name('dashboard.categories');

    // Route untuk pengembalian buku
    Route::get('/dashboard/return-book', [UserDashboardController::class, 'returnBookForm'])->name('dashboard.return.form');
    Route::post('/dashboard/return-book', [UserDashboardController::class, 'processReturn'])->name('dashboard.return.process');
});

// Admin dashboard route - ensure admin role and redirect non-admin users
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin');
        }
        return redirect('/dashboard');
    })->name('admin.dashboard');
});
