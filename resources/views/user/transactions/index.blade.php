@extends('layouts.app')

@section('title', 'Transaksi')

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
    <li>
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
    <li>
        <a href="{{ route('user.feedback') }}">
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
        <h2 class="card-title">Daftar Transaksi</h2>
        <a href="{{ route('user.transactions.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Transaksi
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" class="mb-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <select name="type" class="form-control">
                    <option value="">Semua Tipe</option>
                    <option value="Pemasukan" {{ request('type') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="Pengeluaran" {{ request('type') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="Umum">Umum</option>
                    <option value="Listrik">Listrik</option>
                    <option value="Pembelian Barang">Pembelian Barang</option>
                    <option value="Pajak Kendaraan">Pajak Kendaraan</option>
                    <option value="Pajak Tanah">Pajak Tanah</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="text" name="search" class="form-control" placeholder="Cari deskripsi..." value="{{ request('search') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $transaction->type == 'Pemasukan' ? 'badge-success' : 'badge-danger' }}">
                                {{ $transaction->type }}
                            </span>
                        </td>
                        <td>{{ $transaction->category }}</td>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>{{ Str::limit($transaction->description, 50) }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('user.transactions.show', $transaction) }}" class="btn btn-sm btn-secondary">Lihat</a>
                                <a href="{{ route('user.transactions.edit', $transaction) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form method="POST" action="{{ route('user.transactions.destroy', $transaction) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $transactions->links() }}
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
.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}
</style>
@endsection
