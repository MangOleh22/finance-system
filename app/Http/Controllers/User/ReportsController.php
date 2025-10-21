<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Date range
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Income by category
        $incomeByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'Pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Expense by category
        $expenseByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'Pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Total income and expense
        $totalIncome = $incomeByCategory->sum('total');
        $totalExpense = $expenseByCategory->sum('total');
        $balance = $totalIncome - $totalExpense;

        // Debts summary
        $totalDebt = Debt::where('user_id', $userId)
            ->where('status', 'Belum Lunas')
            ->sum('amount');

        $paidDebt = Debt::where('user_id', $userId)
            ->where('status', 'Lunas')
            ->sum('amount');

        // Bank accounts summary
        $totalBankBalance = BankAccount::where('user_id', $userId)
            ->sum('balance');

        return view('user.reports.index', compact(
            'startDate',
            'endDate',
            'incomeByCategory',
            'expenseByCategory',
            'totalIncome',
            'totalExpense',
            'balance',
            'totalDebt',
            'paidDebt',
            'totalBankBalance'
        ));
    }

    public function export(Request $request)
    {
        $userId = auth()->id();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return Excel::download(
            new TransactionsExport($userId, $startDate, $endDate),
            'laporan-transaksi-' . date('Y-m-d') . '.xlsx'
        );
    }

    public function generate(Request $request)
    {
        $userId = auth()->id();
        $type = $request->get('type', 'monthly');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $data = [];

        if ($type === 'monthly') {
            for ($i = 1; $i <= 12; $i++) {
                $income = Transaction::where('user_id', $userId)
                    ->where('type', 'Pemasukan')
                    ->whereYear('date', $year)
                    ->whereMonth('date', $i)
                    ->sum('amount');

                $expense = Transaction::where('user_id', $userId)
                    ->where('type', 'Pengeluaran')
                    ->whereYear('date', $year)
                    ->whereMonth('date', $i)
                    ->sum('amount');

                $data[] = [
                    'period' => date('F', mktime(0, 0, 0, $i, 1)),
                    'income' => $income,
                    'expense' => $expense,
                    'balance' => $income - $expense,
                ];
            }
        }

        return response()->json($data);
    }
}
