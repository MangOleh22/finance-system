@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
<ul>
    <li class="active">
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
    <li>
        <a href="{{ route('admin.feedback') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Feedback</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.reports') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            <span>Laporan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.backup') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            <span>Backup</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-4 mb-6">
    <div class="stat-card">
        <div class="stat-icon primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <small style="color: var(--gray-600);">{{ $onlineUsers }} online</small>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransactions }}</div>
            <small style="color: var(--gray-600);">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</small>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Hutang Aktif</div>
            <div class="stat-value">{{ $activeDebts }}</div>
            <small style="color: var(--gray-600);">Rp {{ number_format($totalDebtAmount, 0, ',', '.') }}</small>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Feedback</div>
            <div class="stat-value">{{ $totalFeedback }}</div>
            <small style="color: var(--gray-600);">{{ $pendingFeedback }} pending</small>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="grid grid-cols-2 mb-6">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">User Terbaru</h2>
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($recentUsers->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($recentUsers as $user)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: var(--gray-50); border-radius: var(--border-radius);">
                    <div>
                        <div style="font-weight: 600;">{{ $user->username }}</div>
                        <div style="font-size: 13px; color: var(--gray-600);">{{ $user->email }}</div>
                    </div>
                    <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'user' ? 'primary' : 'secondary') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center" style="color: var(--gray-600); padding: 20px 0;">Tidak ada user baru</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Feedback Terbaru</h2>
            <a href="{{ route('admin.feedback') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($recentFeedback->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($recentFeedback as $feedback)
                <div style="padding: 12px; background: var(--gray-50); border-radius: var(--border-radius);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <div style="font-weight: 600;">{{ $feedback->user->username }}</div>
                        <span class="badge badge-{{ $feedback->status == 'pending' ? 'warning' : 'success' }}">
                            {{ ucfirst($feedback->status) }}
                        </span>
                    </div>
                    <div style="font-size: 13px; color: var(--gray-700);">{{ Str::limit($feedback->subject, 50) }}</div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center" style="color: var(--gray-600); padding: 20px 0;">Tidak ada feedback</p>
            @endif
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Transaksi Terbaru</h2>
    </div>
    <div class="card-body">
        @if($recentTransactions->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->username }}</td>
                        <td>{{ $transaction->date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $transaction->type == 'Pemasukan' ? 'badge-success' : 'badge-danger' }}">
                                {{ $transaction->type }}
                            </span>
                        </td>
                        <td>{{ $transaction->category }}</td>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center" style="color: var(--gray-600); padding: 40px 0;">Belum ada transaksi</p>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
.badge-primary {
    background: rgba(59, 130, 246, 0.1);
    color: var(--primary);
}
.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}
.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}
.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}
.badge-secondary {
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary);
}
</style>
@endsection
