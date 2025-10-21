<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Overall statistics
        $totalIncome = Transaction::where('type', 'Pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = Transaction::where('type', 'Pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalDebt = Debt::where('status', 'Belum Lunas')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        // By user
        $userStats = User::where('role', 'user')
            ->withCount(['transactions', 'debts'])
            ->get();

        // By category
        $incomeByCategory = Transaction::where('type', 'Pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $expenseByCategory = Transaction::where('type', 'Pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalIncome',
            'totalExpense',
            'totalDebt',
            'userStats',
            'incomeByCategory',
            'expenseByCategory'
        ));
    }

    public function generate(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $year = $request->get('year', date('Y'));

        $data = [];

        if ($type === 'monthly') {
            for ($i = 1; $i <= 12; $i++) {
                $income = Transaction::where('type', 'Pemasukan')
                    ->whereYear('date', $year)
                    ->whereMonth('date', $i)
                    ->sum('amount');

                $expense = Transaction::where('type', 'Pengeluaran')
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

    public function export($type, $format)
    {
        $filename = 'admin-report-' . $type . '-' . date('Y-m-d') . '.' . $format;

        return Excel::download(
            new AdminReportExport($type),
            $filename
        );
    }
}
