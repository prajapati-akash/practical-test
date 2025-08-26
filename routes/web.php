<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





// Home / dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Auth
Route::get('register', [AuthController::class,'showRegister'])->name('register');
Route::post('register', [AuthController::class,'register'])->name('register.post');

Route::get('activate/{token}', [AuthController::class,'activate'])->name('activate');

Route::get('login', [AuthController::class,'showLogin'])->name('login');
Route::post('login', [AuthController::class,'login'])->name('login.post');

Route::post('logout', [AuthController::class,'logout'])->name('logout')->middleware('auth');

// Admin user management
Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class,'toggleStatus'])->name('users.toggleStatus');
});

// Profile management (registered users can view/update their own profile)
Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [UserController::class, 'update'])->name('profile.update');
});

// Sub-users (admin or parent users)
Route::middleware('auth')->resource('subusers', SubUserController::class);

// Categories & Products (only user & sub_user can view)
Route::middleware(['auth', 'user.access'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});