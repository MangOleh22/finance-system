<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use Illuminate\Http\Request;

class PasswordResetRequestController extends Controller
{
    public function create()
    {
        return view('user.password-reset-request.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        PasswordResetRequest::create($validated);

        return redirect()->route('user.dashboard')
            ->with('success', 'Permintaan reset password berhasil dikirim.');
    }

    public function show($id)
    {
        $request = PasswordResetRequest::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.password-reset-request.show', compact('request'));
    }

    public function cancel($id)
    {
        $request = PasswordResetRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $request->delete();

        return redirect()->route('user.dashboard')
            ->with('success', 'Permintaan reset password dibatalkan.');
    }
}
