<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show($id)
    {
        $feedback = Feedback::with('user', 'repliedBy')->findOrFail($id);

        return view('admin.feedback.show', compact('feedback'));
    }

    public function reply(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $validated = $request->validate([
            'reply' => 'required|string|max:5000',
        ]);

        $feedback->update([
            'reply' => $validated['reply'],
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => auth()->id(),
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback')
            ->with('success', 'Feedback berhasil dihapus.');
    }

    public function markAsRead($id)
    {
        $feedback = Feedback::findOrFail($id);
        // Implement mark as read logic if needed
        return back()->with('success', 'Feedback ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Feedback::where('status', 'pending')->update(['status' => 'closed']);
        return back()->with('success', 'Semua feedback ditandai sudah dibaca.');
    }
}
