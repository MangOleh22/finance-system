<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\SharedItem;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Date range
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get shared transaction IDs
        $sharedTransactionIds = SharedItem::where('shared_with_id', $userId)
            ->where('item_type', Transaction::class)
            ->pluck('item_id');

        // Income by category
        $incomeByCategory = Transaction::whereIn('id', $sharedTransactionIds)
            ->where('type', 'Pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Expense by category
        $expenseByCategory = Transaction::whereIn('id', $sharedTransactionIds)
            ->where('type', 'Pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $totalIncome = $incomeByCategory->sum('total');
        $totalExpense = $expenseByCategory->sum('total');

        return view('viewer.reports.index', compact(
            'startDate',
            'endDate',
            'incomeByCategory',
            'expenseByCategory',
            'totalIncome',
            'totalExpense'
        ));
    }
}
