@extends('layouts.app')

@section('title', 'Laporan Keuangan')

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
<!-- Filter -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('user.reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Export Excel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
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
        <div class="stat-icon {{ $balance >= 0 ? 'primary' : 'warning' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-label">Saldo</div>
            <div class="stat-value" style="color: {{ $balance >= 0 ? 'var(--primary)' : 'var(--danger)' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
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
</div>

<!-- Charts -->
<div class="grid grid-cols-2 mb-6">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pemasukan per Kategori</h2>
        </div>
        <div class="card-body">
            <canvas id="incomeChart"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pengeluaran per Kategori</h2>
        </div>
        <div class="card-body">
            <canvas id="expenseChart"></canvas>
        </div>
    </div>
</div>

<!-- Bank Summary -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Ringkasan Akun Bank</h2>
    </div>
    <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: var(--gray-50); border-radius: var(--border-radius);">
            <div>
                <div style="font-size: 14px; color: var(--gray-600); margin-bottom: 4px;">Total Saldo Bank</div>
                <div style="font-size: 28px; font-weight: 700; color: var(--success);">
                    Rp {{ number_format($totalBankBalance, 0, ',', '.') }}
                </div>
            </div>
            <div>
                <div style="font-size: 14px; color: var(--gray-600); margin-bottom: 4px;">Hutang Belum Lunas</div>
                <div style="font-size: 28px; font-weight: 700; color: var(--danger);">
                    Rp {{ number_format($totalDebt, 0, ',', '.') }}
                </div>
            </div>
            <div>
                <div style="font-size: 14px; color: var(--gray-600); margin-bottom: 4px;">Hutang Lunas</div>
                <div style="font-size: 28px; font-weight: 700; color: var(--gray-500);">
                    Rp {{ number_format($paidDebt, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Income Chart
const incomeCtx = document.getElementById('incomeChart');
const incomeData = @json($incomeByCategory);
new Chart(incomeCtx, {
    type: 'doughnut',
    data: {
        labels: incomeData.map(item => item.category),
        datasets: [{
            data: incomeData.map(item => item.total),
            backgroundColor: [
                '#10b981',
                '#3b82f6',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#06b6d4'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Expense Chart
const expenseCtx = document.getElementById('expenseChart');
const expenseData = @json($expenseByCategory);
new Chart(expenseCtx, {
    type: 'doughnut',
    data: {
        labels: expenseData.map(item => item.category),
        datasets: [{
            data: expenseData.map(item => item.total),
            backgroundColor: [
                '#ef4444',
                '#f59e0b',
                '#8b5cf6',
                '#06b6d4',
                '#10b981',
                '#3b82f6'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
