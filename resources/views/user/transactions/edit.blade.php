@extends('layouts.app')

@section('title', 'Edit Transaksi')

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
        <h2 class="card-title">Edit Transaksi</h2>
        <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.transactions.update', $transaction) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="date" class="form-label">Tanggal *</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Tipe *</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Pemasukan" {{ old('type', $transaction->type) == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="Pengeluaran" {{ old('type', $transaction->type) == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="category" class="form-label">Kategori *</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Umum" {{ old('category', $transaction->category) == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Listrik" {{ old('category', $transaction->category) == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                        <option value="Pembelian Barang" {{ old('category', $transaction->category) == 'Pembelian Barang' ? 'selected' : '' }}>Pembelian Barang</option>
                        <option value="Pajak Kendaraan" {{ old('category', $transaction->category) == 'Pajak Kendaraan' ? 'selected' : '' }}>Pajak Kendaraan</option>
                        <option value="Pajak Tanah" {{ old('category', $transaction->category) == 'Pajak Tanah' ? 'selected' : '' }}>Pajak Tanah</option>
                        <option value="Lainnya" {{ old('category', $transaction->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Jumlah (Rp) *</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', $transaction->amount) }}" min="0" step="0.01" required>
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $transaction->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="receipt" class="form-label">Bukti Transaksi</label>
                @if($transaction->receipt_url)
                    <div style="margin-bottom: 8px;">
                        <a href="{{ Storage::url($transaction->receipt_url) }}" target="_blank" class="btn btn-sm btn-secondary">Lihat Bukti Saat Ini</a>
                    </div>
                @endif
                <input type="file" id="receipt" name="receipt" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <small style="color: var(--gray-600);">Format: JPG, PNG, PDF (Max: 2MB). Kosongkan jika tidak ingin mengubah.</small>
                @error('receipt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_shared" value="1" {{ old('is_shared', $transaction->is_shared) ? 'checked' : '' }}>
                    <span>Bagikan dengan viewer</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Update Transaksi</button>
                <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">Batal</a>
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
