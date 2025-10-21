@extends('layouts.app')

@section('title', 'Manajemen User')

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
    <li>
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
<div class="card mb-6">
    <div class="card-header">
        <h2 class="card-title">Daftar User</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah User
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="mb-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <select name="role" class="form-control">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="text" name="search" class="form-control" placeholder="Cari username atau email..." value="{{ request('search') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div class="avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                    <span>{{ substr($user->username, 0, 2) }}</span>
                                </div>
                                <strong>{{ $user->username }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'user' ? 'primary' : 'secondary') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->isOnline())
                                <span class="badge badge-success">Online</span>
                            @else
                                <span class="badge badge-secondary">Offline</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 4px;">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-secondary" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                @if($user->role != 'admin')
                                <a href="{{ route('admin.users.impersonate', $user) }}" class="btn btn-sm btn-warning" title="Impersonate">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </a>
                                @endif
                                @if($user->id != auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
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
