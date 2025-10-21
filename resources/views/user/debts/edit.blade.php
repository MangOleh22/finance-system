@extends('layouts.app')

@section('title', 'Edit Hutang')

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
        <h2 class="card-title">Edit Hutang</h2>
        <a href="{{ route('user.debts') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.debts.update', $debt->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="date" class="form-label">Tanggal *</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $debt->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Jumlah (Rp) *</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', $debt->amount) }}" min="0" step="0.01" required>
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="debtor" class="form-label">Nama Debitur *</label>
                    <input type="text" id="debtor" name="debtor" class="form-control" value="{{ old('debtor', $debt->debtor) }}" required>
                    @error('debtor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="Belum Lunas" {{ old('status', $debt->status) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="Lunas" {{ old('status', $debt->status) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $debt->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="document" class="form-label">Dokumen Hutang</label>
                @if($debt->document_url)
                    <div style="margin-bottom: 8px;">
                        <a href="{{ Storage::url($debt->document_url) }}" target="_blank" class="btn btn-sm btn-secondary">Lihat Dokumen Saat Ini</a>
                    </div>
                @endif
                <input type="file" id="document" name="document" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <small style="color: var(--gray-600);">Format: JPG, PNG, PDF (Max: 2MB). Kosongkan jika tidak ingin mengubah.</small>
                @error('document')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_shared" value="1" {{ old('is_shared', $debt->is_shared) ? 'checked' : '' }}>
                    <span>Bagikan dengan viewer</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Update Hutang</button>
                <a href="{{ route('user.debts') }}" class="btn btn-secondary">Batal</a>
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
