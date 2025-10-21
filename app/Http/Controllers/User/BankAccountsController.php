<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountsController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBalance = $bankAccounts->sum('balance');

        return view('user.bank-accounts.index', compact('bankAccounts', 'totalBalance'));
    }

    public function create()
    {
        return view('user.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'is_shared' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_shared'] = $request->has('is_shared');

        BankAccount::create($validated);

        return redirect()->route('user.bank-accounts')
            ->with('success', 'Akun bank berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bankAccount = BankAccount::where('user_id', auth()->id())->findOrFail($id);

        return view('user.bank-accounts.show', compact('bankAccount'));
    }

    public function edit($id)
    {
        $bankAccount = BankAccount::where('user_id', auth()->id())->findOrFail($id);

        return view('user.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, $id)
    {
        $bankAccount = BankAccount::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'is_shared' => 'boolean',
        ]);

        $validated['is_shared'] = $request->has('is_shared');

        $bankAccount->update($validated);

        return redirect()->route('user.bank-accounts')
            ->with('success', 'Akun bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::where('user_id', auth()->id())->findOrFail($id);

        $bankAccount->delete();

        return redirect()->route('user.bank-accounts')
            ->with('success', 'Akun bank berhasil dihapus.');
    }
}
