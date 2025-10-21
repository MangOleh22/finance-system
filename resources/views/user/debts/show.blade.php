@extends('layouts.app')

@section('title', 'Detail Hutang')

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
        <a href="{{ route('user.debts') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span>Hutang</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detail Hutang</h2>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('user.debts.edit', $debt->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('user.debts') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2">
            <div class="detail-group">
                <label class="detail-label">Tanggal</label>
                <p class="detail-value">{{ $debt->date->format('d F Y') }}</p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Status</label>
                <p class="detail-value">
                    <span class="badge {{ $debt->status == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                        {{ $debt->status }}
                    </span>
                </p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Nama Debitur</label>
                <p class="detail-value" style="font-size: 20px; font-weight: 600;">{{ $debt->debtor }}</p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Jumlah Hutang</label>
                <p class="detail-value" style="font-size: 28px; font-weight: 700; color: var(--warning);">
                    Rp {{ number_format($debt->amount, 0, ',', '.') }}
                </p>
            </div>

            @if($debt->description)
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Deskripsi</label>
                <p class="detail-value">{{ $debt->description }}</p>
            </div>
            @endif

            @if($debt->document_url)
            <div class="detail-group" style="grid-column: 1 / -1;">
                <label class="detail-label">Dokumen Hutang</label>
                <div>
                    <a href="{{ Storage::url($debt->document_url) }}" target="_blank" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Lihat Dokumen
                    </a>
                </div>
            </div>
            @endif

            <div class="detail-group">
                <label class="detail-label">Status Sharing</label>
                <p class="detail-value">
                    <span class="badge {{ $debt->is_shared ? 'badge-success' : 'badge-secondary' }}">
                        {{ $debt->is_shared ? 'Dibagikan' : 'Tidak Dibagikan' }}
                    </span>
                </p>
            </div>

            <div class="detail-group">
                <label class="detail-label">Dibuat Pada</label>
                <p class="detail-value">{{ $debt->created_at->format('d F Y H:i') }}</p>
            </div>
        </div>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('user.debts.destroy', $debt->id) }}" onsubmit="return confirm('Yakin ingin menghapus hutang ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Hapus Hutang
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
