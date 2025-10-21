<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use App\Models\SharedItem;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get shared items
        $sharedTransactionIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Transaction::class)
            ->pluck('item_id');

        $sharedDebtIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Debt::class)
            ->pluck('item_id');

        $sharedBankAccountIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', BankAccount::class)
            ->pluck('item_id');

        // Statistics
        $totalSharedTransactions = $sharedTransactionIds->count();
        $totalSharedDebts = $sharedDebtIds->count();
        $totalSharedBankAccounts = $sharedBankAccountIds->count();

        // Recent shared transactions
        $recentTransactions = Transaction::whereIn('id', $sharedTransactionIds)
            ->with('user')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('viewer.dashboard', compact(
            'totalSharedTransactions',
            'totalSharedDebts',
            'totalSharedBankAccounts',
            'recentTransactions'
        ));
    }
}
