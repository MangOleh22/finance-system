@extends('layouts.app')

@section('title', 'Hutang')

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
<!-- Statistics -->
<div class="grid grid-cols-2 mb-6">
    <div class="stat-card">
        <div class="stat-icon warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Hutang Belum Lunas</div>
            <div class="stat-value">Rp {{ number_format($totalDebt, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Hutang Lunas</div>
            <div class="stat-value">Rp {{ number_format($paidDebt, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Hutang</h2>
        <a href="{{ route('user.debts.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Hutang
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" class="mb-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="text" name="search" class="form-control" placeholder="Cari debitur..." value="{{ request('search') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('user.debts') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Debitur</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($debts as $debt)
                    <tr>
                        <td>{{ $debt->date->format('d/m/Y') }}</td>
                        <td><strong>{{ $debt->debtor }}</strong></td>
                        <td>Rp {{ number_format($debt->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $debt->status == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                                {{ $debt->status }}
                            </span>
                        </td>
                        <td>{{ Str::limit($debt->description, 50) }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('user.debts.show', $debt->id) }}" class="btn btn-sm btn-secondary">Lihat</a>
                                <a href="{{ route('user.debts.edit', $debt->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form method="POST" action="{{ route('user.debts.destroy', $debt->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada hutang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $debts->links() }}
        </div>
    </div>
</div>

<style>
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
</style>
@endsection
