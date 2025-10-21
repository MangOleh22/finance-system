<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\SharedItem;
use Illuminate\Http\Request;

class BankAccountsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get shared bank account IDs
        $sharedIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', BankAccount::class)
            ->pluck('item_id');

        $bankAccounts = BankAccount::whereIn('id', $sharedIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBalance = $bankAccounts->sum('balance');

        return view('viewer.bank-accounts.index', compact('bankAccounts', 'totalBalance'));
    }

    public function show($id)
    {
        $userId = auth()->id();

        // Verify access
        $hasAccess = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', BankAccount::class)
            ->where('item_id', $id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access.');
        }

        $bankAccount = BankAccount::with('user')->findOrFail($id);

        return view('viewer.bank-accounts.show', compact('bankAccount'));
    }
}
