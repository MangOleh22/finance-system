@extends('layouts.app')

@section('title', 'Tambah Akun Bank')

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
        <h2 class="card-title">Tambah Akun Bank Baru</h2>
        <a href="{{ route('user.bank-accounts') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.bank-accounts.store') }}">
            @csrf

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="bank_name" class="form-label">Nama Bank *</label>
                    <input type="text" id="bank_name" name="bank_name" class="form-control" value="{{ old('bank_name') }}" required placeholder="Contoh: BCA, Mandiri, BNI">
                    @error('bank_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="account_number" class="form-label">Nomor Rekening *</label>
                    <input type="text" id="account_number" name="account_number" class="form-control" value="{{ old('account_number') }}" required placeholder="1234567890">
                    @error('account_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="account_name" class="form-label">Nama Pemilik Rekening *</label>
                    <input type="text" id="account_name" name="account_name" class="form-control" value="{{ old('account_name') }}" required>
                    @error('account_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="balance" class="form-label">Saldo Awal (Rp) *</label>
                    <input type="number" id="balance" name="balance" class="form-control" value="{{ old('balance', 0) }}" min="0" step="0.01" required>
                    @error('balance')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_shared" value="1" {{ old('is_shared') ? 'checked' : '' }}>
                    <span>Bagikan dengan viewer</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Simpan Akun Bank</button>
                <a href="{{ route('user.bank-accounts') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
.text-danger {
    color: var(--danger);
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
</style>
@endsection
