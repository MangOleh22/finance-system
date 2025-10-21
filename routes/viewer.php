<?php

use App\Http\Controllers\Viewer\DashboardController;
use App\Http\Controllers\Viewer\TransactionsController;
use App\Http\Controllers\Viewer\DebtsController;
use App\Http\Controllers\Viewer\BankAccountsController;
use App\Http\Controllers\Viewer\ReportsController;
use App\Http\Controllers\Viewer\FeedbackController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Transactions
Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions');
Route::get('/transactions/{id}', [TransactionsController::class, 'show'])->name('transactions.show');

// Debts
Route::get('/debts', [DebtsController::class, 'index'])->name('debts');
Route::get('/debts/{id}', [DebtsController::class, 'show'])->name('debts.show');

// Bank Accounts
Route::get('/bank-accounts', [BankAccountsController::class, 'index'])->name('bank-accounts');
Route::get('/bank-accounts/{id}', [BankAccountsController::class, 'show'])->name('bank-accounts.show');

// Reports
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');

// Feedback
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
