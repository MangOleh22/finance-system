@extends('layouts.app')

@section('title', 'Dashboard User')

@section('sidebar')
<ul>
    <li class="active">
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
<!-- Statistics Cards -->
<div class="grid grid-cols-4 mb-6">
    <div class="stat-card">
        <div class="stat-icon success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Pemasukan</div>
            <div class="stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                <polyline points="17 6 23 6 23 12"></polyline>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Pengeluaran</div>
            <div class="stat-value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Hutang</div>
            <div class="stat-value">Rp {{ number_format($totalDebt, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Saldo Bank</div>
            <div class="stat-value">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="card mb-6">
    <div class="card-header">
        <h2 class="card-title">Grafik Keuangan Tahun {{ date('Y') }}</h2>
    </div>
    <div class="card-body">
        <canvas id="financialChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Transaksi Terbaru</h2>
        <a href="{{ route('user.transactions.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($recentTransactions->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center" style="color: var(--gray-600); padding: 40px 0;">Belum ada transaksi</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('financialChart');
const monthlyIncome = @json(array_values($monthlyIncome));
const monthlyExpense = @json(array_values($monthlyExpense));

// Fill missing months with 0
const incomeData = Array(12).fill(0);
const expenseData = Array(12).fill(0);

Object.keys(@json($monthlyIncome)).forEach(month => {
    incomeData[month - 1] = @json($monthlyIncome)[month];
});

Object.keys(@json($monthlyExpense)).forEach(month => {
    expenseData[month - 1] = @json($monthlyExpense)[month];
});

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Pemasukan',
            data: incomeData,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4
        }, {
            label: 'Pengeluaran',
            data: expenseData,
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endsection

@section('styles')
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
