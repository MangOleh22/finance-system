@extends('layouts.app')

@section('title', 'Akun Bank')

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
    <li>
        <a href="{{ route('user.transactions.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>Transaksi</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.debts') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span>Hutang</span>
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
    <li>
        <a href="{{ route('user.reports') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            <span>Laporan</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<!-- Summary Card -->
<div class="card mb-6">
    <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 14px; color: var(--gray-600); margin-bottom: 8px;">Total Saldo</div>
                <div style="font-size: 32px; font-weight: 700; color: var(--primary);">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </div>
            </div>
            <a href="{{ route('user.bank-accounts.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Akun Bank
            </a>
        </div>
    </div>
</div>

<!-- Bank Accounts List -->
<div class="grid grid-cols-3">
    @forelse($bankAccounts as $account)
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 16px;">
                <div style="flex: 1;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 4px;">{{ $account->bank_name }}</h3>
                    <p style="font-size: 13px; color: var(--gray-600);">{{ $account->account_number }}</p>
                </div>
                @if($account->is_shared)
                <span class="badge badge-primary" style="font-size: 11px;">Shared</span>
                @endif
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 13px; color: var(--gray-600); margin-bottom: 4px;">Nama Pemilik</div>
                <div style="font-weight: 500;">{{ $account->account_name }}</div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; color: var(--gray-600); margin-bottom: 4px;">Saldo</div>
                <div style="font-size: 24px; font-weight: 700; color: var(--success);">
                    Rp {{ number_format($account->balance, 0, ',', '.') }}
                </div>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('user.bank-accounts.show', $account->id) }}" class="btn btn-sm btn-secondary" style="flex: 1;">Lihat</a>
                <a href="{{ route('user.bank-accounts.edit', $account->id) }}" class="btn btn-sm btn-primary" style="flex: 1;">Edit</a>
                <form method="POST" action="{{ route('user.bank-accounts.destroy', $account->id) }}" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" style="width: 100%;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-body text-center" style="padding: 60px 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 16px; color: var(--gray-400);">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <p style="color: var(--gray-600); margin-bottom: 16px;">Belum ada akun bank</p>
            <a href="{{ route('user.bank-accounts.create') }}" class="btn btn-primary">Tambah Akun Bank</a>
        </div>
    </div>
    @endforelse
</div>

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
</style>
@endsection
