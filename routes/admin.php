<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\PasswordResetRequestController;

// Admin Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// User Management
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
});

// Financial Reports
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports');
    Route::get('/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/export/{type}/{format}', [ReportController::class, 'export'])->name('reports.export');
});

// Backup & Export
Route::prefix('backup')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->name('backup');
    Route::post('/create/{type}', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
    Route::delete('/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy');
    Route::get('/export/{type}/{format}', [BackupController::class, 'export'])->name('backup.export');
});

// Feedback
Route::prefix('feedback')->group(function () {
    Route::get('/', [FeedbackController::class, 'index'])->name('feedback');
    Route::get('/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::post('/{id}/mark-as-read', [FeedbackController::class, 'markAsRead'])->name('feedback.mark-as-read');
    Route::post('/mark-all-as-read', [FeedbackController::class, 'markAllAsRead'])->name('feedback.mark-all-as-read');
    Route::post('/{id}/reply', [FeedbackController::class, 'reply'])->name('feedback.reply');
    Route::delete('/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

// Password Reset Requests
Route::prefix('password-reset-requests')->name('password-reset-requests.')->group(function () {
    Route::get('/', [PasswordResetRequestController::class, 'index'])->name('index');
    Route::get('/{id}', [PasswordResetRequestController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [PasswordResetRequestController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [PasswordResetRequestController::class, 'reject'])->name('reject');
});
