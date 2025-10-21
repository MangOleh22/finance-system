<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PasswordResetRequest::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.password-reset-requests.index', compact('requests'));
    }

    public function show($id)
    {
        $resetRequest = PasswordResetRequest::with('user', 'processedBy')->findOrFail($id);

        return view('admin.password-reset-requests.show', compact('resetRequest'));
    }

    public function approve(Request $request, $id)
    {
        $resetRequest = PasswordResetRequest::findOrFail($id);

        $validated = $request->validate([
            'new_password' => 'required|min:6|confirmed',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        // Update user password
        $resetRequest->user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        // Update request status
        $resetRequest->update([
            'status' => 'approved',
            'admin_note' => $validated['admin_note'] ?? null,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.password-reset-requests.index')
            ->with('success', 'Permintaan reset password disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $resetRequest = PasswordResetRequest::findOrFail($id);

        $validated = $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $resetRequest->update([
            'status' => 'rejected',
            'admin_note' => $validated['admin_note'],
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.password-reset-requests.index')
            ->with('success', 'Permintaan reset password ditolak.');
    }
}
