<?php

namespace App\Http\Controllers\Viewer;

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

        return view('viewer.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('viewer.feedback.create');
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

        return redirect()->route('viewer.feedback')
            ->with('success', 'Feedback berhasil dikirim.');
    }

    public function show($id)
    {
        $feedback = Feedback::where('user_id', auth()->id())->findOrFail($id);

        return view('viewer.feedback.show', compact('feedback'));
    }
}
