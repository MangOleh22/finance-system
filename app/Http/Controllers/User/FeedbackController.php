<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('user.feedback.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Feedback::create($validated);

        return redirect()->route('user.feedback')
            ->with('success', 'Feedback berhasil dikirim.');
    }

    public function show($id)
    {
        $feedback = Feedback::where('user_id', auth()->id())->findOrFail($id);

        return view('user.feedback.show', compact('feedback'));
    }

    public function destroy($id)
    {
        $feedback = Feedback::where('user_id', auth()->id())->findOrFail($id);

        $feedback->delete();

        return redirect()->route('user.feedback')
            ->with('success', 'Feedback berhasil dihapus.');
    }
}
