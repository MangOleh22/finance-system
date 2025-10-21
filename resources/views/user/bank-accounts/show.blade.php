@extends('layouts.app')

@section('title', 'Detail Akun Bank')

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
        <a href="{{ route('user.bank-accounts') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Akun Bank</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detail Akun Bank</h2>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('user.bank-accounts.edit', $bankAccount->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('user.bank-accounts') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2">
            <div class="form-group">
                <label class="form-label">Nama Bank</label>
                <p style="font-size: 18px; font-weight: 600;">{{ $bankAccount->bank_name }}</p>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Rekening</label>
                <p style="font-size: 18px; font-weight: 600; font-family: monospace;">{{ $bankAccount->account_number }}</p>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Pemilik</label>
                <p style="font-size: 16px;">{{ $bankAccount->account_name }}</p>
            </div>

            <div class="form-group">
                <label class="form-label">Saldo</label>
                <p style="font-size: 32px; font-weight: 700; color: var(--success);">
                    Rp {{ number_format($bankAccount->balance, 0, ',', '.') }}
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Status Sharing</label>
                <p>
                    @if($bankAccount->is_shared)
                        <span class="badge badge-success">Dibagikan dengan Viewer</span>
                    @else
                        <span class="badge badge-secondary">Tidak Dibagikan</span>
                    @endif
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Dibuat Pada</label>
                <p>{{ $bankAccount->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('user.bank-accounts.destroy', $bankAccount->id) }}" onsubmit="return confirm('Yakin ingin menghapus akun bank ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Hapus Akun Bank
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.badge {
    padding: 6px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
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
