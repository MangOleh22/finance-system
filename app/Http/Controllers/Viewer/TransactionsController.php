<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\SharedItem;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Get shared transaction IDs
        $sharedIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Transaction::class)
            ->pluck('item_id');

        $query = Transaction::whereIn('id', $sharedIds)
            ->with('user')
            ->orderBy('date', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(15);

        return view('viewer.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $userId = auth()->id();

        // Verify access
        $hasAccess = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Transaction::class)
            ->where('item_id', $id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access.');
        }

        $transaction = Transaction::with('user')->findOrFail($id);

        return view('viewer.transactions.show', compact('transaction'));
    }
}
