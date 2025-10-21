<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user,viewer',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $transactions = $user->transactions()->orderBy('date', 'desc')->limit(10)->get();
        $debts = $user->debts()->orderBy('date', 'desc')->limit(10)->get();
        $bankAccounts = $user->bankAccounts()->get();

        return view('admin.users.show', compact('user', 'transactions', 'debts', 'bankAccounts'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,viewer',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil direset.');
    }

    public function impersonate(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat impersonate admin.');
        }

        session(['impersonate_user_id' => $user->id]);
        session(['admin_id' => auth()->id()]);

        auth()->login($user);

        if ($user->isUser()) {
            return redirect()->route('user.dashboard');
        } elseif ($user->isViewer()) {
            return redirect()->route('viewer.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function stopImpersonating()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }

        $adminId = session('admin_id');
        session()->forget(['impersonate_user_id', 'admin_id']);

        $admin = User::find($adminId);
        auth()->login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kembali ke akun admin.');
    }
}
