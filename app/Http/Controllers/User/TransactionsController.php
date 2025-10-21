<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->orderBy('date', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(15);

        return view('user.transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('user.transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|in:Umum,Listrik,Pembelian Barang,Pajak Kendaraan,Pajak Tanah,Lainnya',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'is_shared' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_shared'] = $request->has('is_shared');

        // Handle file upload
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_url'] = $path;
        }

        Transaction::create($validated);

        return redirect()->route('user.transactions')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('user.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        return view('user.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Pemasukan,Pengeluaran',
            'category' => 'required|in:Umum,Listrik,Pembelian Barang,Pajak Kendaraan,Pajak Tanah,Lainnya',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'is_shared' => 'boolean',
        ]);

        $validated['is_shared'] = $request->has('is_shared');

        // Handle file upload
        if ($request->hasFile('receipt')) {
            // Delete old file
            if ($transaction->receipt_url) {
                Storage::disk('public')->delete($transaction->receipt_url);
            }
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_url'] = $path;
        }

        $transaction->update($validated);

        return redirect()->route('user.transactions')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        // Delete file if exists
        if ($transaction->receipt_url) {
            Storage::disk('public')->delete($transaction->receipt_url);
        }

        $transaction->delete();

        return redirect()->route('user.transactions')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
