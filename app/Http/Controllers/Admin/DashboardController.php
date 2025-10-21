<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = User::where('role', 'user')->count();
        $totalViewers = User::where('role', 'viewer')->count();
        $onlineUsers = User::where('is_online', true)->count();

        // Transaction statistics
        $totalTransactions = Transaction::count();
        $totalIncome = Transaction::where('type', 'Pemasukan')->sum('amount');
        $totalExpense = Transaction::where('type', 'Pengeluaran')->sum('amount');

        // Debt statistics
        $totalDebts = Debt::count();
        $activeDebts = Debt::where('status', 'Belum Lunas')->count();
        $totalDebtAmount = Debt::where('status', 'Belum Lunas')->sum('amount');

        // Feedback statistics
        $totalFeedback = Feedback::count();
        $pendingFeedback = Feedback::where('status', 'pending')->count();
        $repliedFeedback = Feedback::where('status', 'replied')->count();

        // Recent activities
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $recentFeedback = Feedback::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalRegularUsers',
            'totalViewers',
            'onlineUsers',
            'totalTransactions',
            'totalIncome',
            'totalExpense',
            'totalDebts',
            'activeDebts',
            'totalDebtAmount',
            'totalFeedback',
            'pendingFeedback',
            'repliedFeedback',
            'recentUsers',
            'recentTransactions',
            'recentFeedback'
        ));
    }
}
