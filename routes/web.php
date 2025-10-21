<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isUser()) {
        return redirect()->route('user.dashboard');
    } elseif ($user->isViewer()) {
        return redirect()->route('viewer.dashboard');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    require base_path('routes/admin.php');
});

// User Routes
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    require base_path('routes/user.php');
});

// Viewer Routes
Route::prefix('viewer')->name('viewer.')->middleware(['auth', 'role:viewer'])->group(function () {
    require base_path('routes/viewer.php');
});

// Stop Impersonating
Route::get('/stop-impersonating', [UserController::class, 'stopImpersonating'])
    ->middleware('auth')
    ->name('stop-impersonating');
