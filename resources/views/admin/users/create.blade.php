@extends('layouts.app')

@section('title', 'Tambah User')

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
    <li class="active">
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
</ul>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Tambah User Baru</h2>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Simpan User</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@section('styles')
<style>
.text-danger {
    color: var(--danger);
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
</style>
@endsection
@endsection
