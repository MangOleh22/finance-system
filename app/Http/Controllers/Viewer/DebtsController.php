<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\SharedItem;
use Illuminate\Http\Request;

class DebtsController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Get shared debt IDs
        $sharedIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Debt::class)
            ->pluck('item_id');

        $query = Debt::whereIn('id', $sharedIds)
            ->with('user')
            ->orderBy('date', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $debts = $query->paginate(15);

        return view('viewer.debts.index', compact('debts'));
    }

    public function show($id)
    {
        $userId = auth()->id();

        // Verify access
        $hasAccess = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Debt::class)
            ->where('item_id', $id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access.');
        }

        $debt = Debt::with('user')->findOrFail($id);

        return view('viewer.debts.show', compact('debt'));
    }
}
