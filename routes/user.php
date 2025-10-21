<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ReportsController;
use App\Http\Controllers\User\TransactionsController;
use App\Http\Controllers\User\BackupController;
use App\Http\Controllers\User\DebtsController;
use App\Http\Controllers\User\BankAccountsController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\PasswordResetRequestController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Profile
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

// Settings
Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
Route::put('/settings/password', [DashboardController::class, 'updatePassword'])->name('settings.password');

// Transactions
Route::resource('transactions', TransactionsController::class);

// Reports
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');
Route::get('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');

// Export & Import
Route::get('/backup', [BackupController::class, 'index'])->name('backup');
Route::post('/backup/export', [BackupController::class, 'export'])->name('backup.export');
Route::post('/backup/import', [BackupController::class, 'import'])->name('backup.import');

// Debts
Route::get('/debts', [DebtsController::class, 'index'])->name('debts');
Route::get('/debts/create', [DebtsController::class, 'create'])->name('debts.create');
Route::post('/debts', [DebtsController::class, 'store'])->name('debts.store');
Route::get('/debts/{id}', [DebtsController::class, 'show'])->name('debts.show');
Route::get('/debts/{id}/edit', [DebtsController::class, 'edit'])->name('debts.edit');
Route::put('/debts/{id}', [DebtsController::class, 'update'])->name('debts.update');
Route::delete('/debts/{id}', [DebtsController::class, 'destroy'])->name('debts.destroy');

// Bank Accounts
Route::get('/bank-accounts', [BankAccountsController::class, 'index'])->name('bank-accounts');
Route::get('/bank-accounts/create', [BankAccountsController::class, 'create'])->name('bank-accounts.create');
Route::post('/bank-accounts', [BankAccountsController::class, 'store'])->name('bank-accounts.store');
Route::get('/bank-accounts/{id}', [BankAccountsController::class, 'show'])->name('bank-accounts.show');
Route::get('/bank-accounts/{id}/edit', [BankAccountsController::class, 'edit'])->name('bank-accounts.edit');
Route::put('/bank-accounts/{id}', [BankAccountsController::class, 'update'])->name('bank-accounts.update');
Route::delete('/bank-accounts/{id}', [BankAccountsController::class, 'destroy'])->name('bank-accounts.destroy');

// Feedback
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

// Password Reset Request
Route::prefix('password-reset-request')->name('password-reset-request.')->group(function () {
    Route::get('/create', [PasswordResetRequestController::class, 'create'])->name('create');
    Route::post('/', [PasswordResetRequestController::class, 'store'])->name('store');
    Route::get('/{id}', [PasswordResetRequestController::class, 'show'])->name('show');
    Route::delete('/{id}', [PasswordResetRequestController::class, 'cancel'])->name('cancel');
});

// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/financial-data', [DashboardController::class, 'getFinancialData'])->name('financial-data');
});
