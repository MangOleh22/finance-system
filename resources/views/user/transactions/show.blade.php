@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('sidebar')
<ul>
    <li>
        <a href="{{ route('user.dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('user.transactions.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>Transaksi</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detail Transaksi</h2>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('user.transactions.edit', $transaction) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2">
            <div class="detail-group">
                <label class="detail-label">Tanggal</label>
                <p class="detail-value">{{ $transaction->date->format('d F Y') }}</p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Tipe</label>
                <p class="detail-value">
                    <span class="badge {{ $transaction->type == 'Pemasukan' ? 'badge-success' : 'badge-danger' }}">
                        {{ $transaction->type }}
                    </span>
                </p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Kategori</label>
                <p class="detail-value">{{ $transaction->category }}</p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Jumlah</label>
                <p class="detail-value" style="font-size: 28px; font-weight: 700; color: {{ $transaction->type == 'Pemasukan' ? 'var(--success)' : 'var(--danger)' }};">
                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                </p>
            </div>

            @if($transaction->description)
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Deskripsi</label>
                <p class="detail-value">{{ $transaction->description }}</p>
            </div>
            @endif

            @if($transaction->receipt_url)
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Bukti Transaksi</label>
                <div>
                    <a href="{{ Storage::url($transaction->receipt_url) }}" target="_blank" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        Lihat Bukti
                    </a>
                </div>
            </div>
            @endif

            <div class="detail-group">
                <label class="detail-label">Status Sharing</label>
                <p class="detail-value">
                    <span class="badge {{ $transaction->is_shared ? 'badge-success' : 'badge-secondary' }}">
                        {{ $transaction->is_shared ? 'Dibagikan' : 'Tidak Dibagikan' }}
                    </span>
                </p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Dibuat Pada</label>
                <p class="detail-value">{{ $transaction->created_at->format('d F Y H:i') }}</p>
            </div>
        </div>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('user.transactions.destroy', $transaction) }}" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Hapus Transaksi
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.detail-group {
    margin-bottom: 20px;
}

.detail-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 16px;
    color: var(--gray-900);
    margin: 0;
}

.badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}
.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}
.badge-secondary {
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary);
}
</style>
@endsection
