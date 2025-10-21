@extends('layouts.app')

@section('title', 'Feedback Management')

@section('sidebar')
<ul>
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Manajemen User</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('admin.feedback') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Feedback</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Feedback</h2>
        <form method="GET" style="display: flex; gap: 8px;">
            <select name="status" class="form-control" style="width: 200px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <div class="card-body">
        @forelse($feedbacks as $feedback)
        <div style="padding: 20px; background: var(--gray-50); border-radius: var(--border-radius); margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                <div style="flex: 1;">
                    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 4px;">{{ $feedback->subject }}</h3>
                    <p style="font-size: 13px; color: var(--gray-600);">
                        Dari: <strong>{{ $feedback->user->username }}</strong> • 
                        {{ $feedback->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
                <span class="badge badge-{{ $feedback->status == 'pending' ? 'warning' : ($feedback->status == 'replied' ? 'success' : 'secondary') }}">
                    {{ ucfirst($feedback->status) }}
                </span>
            </div>
            
            <p style="color: var(--gray-700); margin-bottom: 12px;">{{ Str::limit($feedback->message, 200) }}</p>
            
            @if($feedback->reply)
            <div style="padding: 16px; background: white; border-left: 3px solid var(--success); border-radius: var(--border-radius); margin-bottom: 12px;">
                <div style="font-size: 13px; font-weight: 600; color: var(--success); margin-bottom: 8px;">Balasan Anda:</div>
                <p style="color: var(--gray-700);">{{ $feedback->reply }}</p>
            </div>
            @endif
            
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.feedback.show', $feedback->id) }}" class="btn btn-sm btn-primary">
                    {{ $feedback->status == 'pending' ? 'Balas' : 'Lihat Detail' }}
                </a>
                @if($feedback->status == 'pending')
                <form method="POST" action="{{ route('admin.feedback.destroy', $feedback->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center" style="padding: 60px 20px;">
            <p style="color: var(--gray-600);">Tidak ada feedback</p>
        </div>
        @endforelse

        @if($feedbacks->hasPages())
        <div class="mt-4">
            {{ $feedbacks->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.badge {
    padding: 6px 16px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}
.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}
.badge-secondary {
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary);
}
</style>
@endsection
