<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DebtsController extends Controller
{
    public function index(Request $request)
    {
        $query = Debt::where('user_id', auth()->id())
            ->orderBy('date', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('debtor', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $debts = $query->paginate(15);

        // Statistics
        $totalDebt = Debt::where('user_id', auth()->id())
            ->where('status', 'Belum Lunas')
            ->sum('amount');

        $paidDebt = Debt::where('user_id', auth()->id())
            ->where('status', 'Lunas')
            ->sum('amount');

        return view('user.debts.index', compact('debts', 'totalDebt', 'paidDebt'));
    }

    public function create()
    {
        return view('user.debts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'debtor' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:Belum Lunas,Lunas',
            'is_shared' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_shared'] = $request->has('is_shared');

        // Handle file upload
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $validated['document_url'] = $path;
        }

        Debt::create($validated);

        return redirect()->route('user.debts')
            ->with('success', 'Hutang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $debt = Debt::where('user_id', auth()->id())->findOrFail($id);

        return view('user.debts.show', compact('debt'));
    }

    public function edit($id)
    {
        $debt = Debt::where('user_id', auth()->id())->findOrFail($id);

        return view('user.debts.edit', compact('debt'));
    }

    public function update(Request $request, $id)
    {
        $debt = Debt::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'debtor' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:Belum Lunas,Lunas',
            'is_shared' => 'boolean',
        ]);

        $validated['is_shared'] = $request->has('is_shared');

        // Handle file upload
        if ($request->hasFile('document')) {
            // Delete old file
            if ($debt->document_url) {
                Storage::disk('public')->delete($debt->document_url);
            }
            $path = $request->file('document')->store('documents', 'public');
            $validated['document_url'] = $path;
        }

        $debt->update($validated);

        return redirect()->route('user.debts')
            ->with('success', 'Hutang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $debt = Debt::where('user_id', auth()->id())->findOrFail($id);

        // Delete file if exists
        if ($debt->document_url) {
            Storage::disk('public')->delete($debt->document_url);
        }

        $debt->delete();

        return redirect()->route('user.debts')
            ->with('success', 'Hutang berhasil dihapus.');
    }
}
