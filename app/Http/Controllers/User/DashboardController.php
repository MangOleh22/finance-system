<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Statistics
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'Pemasukan')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'Pengeluaran')
            ->sum('amount');

        $totalDebt = Debt::where('user_id', $userId)
            ->where('status', 'Belum Lunas')
            ->sum('amount');

        $totalBalance = BankAccount::where('user_id', $userId)
            ->sum('balance');

        // Recent transactions
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // Monthly data for chart
        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'Pemasukan')
            ->whereYear('date', date('Y'))
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'Pengeluaran')
            ->whereYear('date', date('Y'))
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('user.dashboard', compact(
            'totalIncome',
            'totalExpense',
            'totalDebt',
            'totalBalance',
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpense'
        ));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function settings()
    {
        return view('user.settings');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function getFinancialData(Request $request)
    {
        $userId = auth()->id();
        $year = $request->get('year', date('Y'));

        $monthlyData = [];
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

            $monthlyData[] = [
                'month' => $i,
                'income' => $income,
                'expense' => $expense,
            ];
        }

        return response()->json($monthlyData);
    }
}
