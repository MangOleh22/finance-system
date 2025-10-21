<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserDataExport implements WithMultipleSheets
{
    protected $userId;
    protected $type;

    public function __construct($userId, $type = 'all')
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->type === 'all' || $this->type === 'transactions') {
            $sheets[] = new TransactionsSheet($this->userId);
        }

        if ($this->type === 'all' || $this->type === 'debts') {
            $sheets[] = new DebtsSheet($this->userId);
        }

        if ($this->type === 'all' || $this->type === 'bank_accounts') {
            $sheets[] = new BankAccountsSheet($this->userId);
        }

        return $sheets;
    }
}

class TransactionsSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return Transaction::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Tanggal', 'Tipe', 'Kategori', 'Jumlah', 'Deskripsi'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->date->format('Y-m-d'),
            $transaction->type,
            $transaction->category,
            $transaction->amount,
            $transaction->description,
        ];
    }
}

class DebtsSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return Debt::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Tanggal', 'Jumlah', 'Debitur', 'Deskripsi', 'Status'];
    }

    public function map($debt): array
    {
        return [
            $debt->id,
            $debt->date->format('Y-m-d'),
            $debt->amount,
            $debt->debtor,
            $debt->description,
            $debt->status,
        ];
    }
}

class BankAccountsSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return BankAccount::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Bank', 'Nomor Rekening', 'Nama Pemilik', 'Saldo'];
    }

    public function map($account): array
    {
        return [
            $account->id,
            $account->bank_name,
            $account->account_number,
            $account->account_name,
            $account->balance,
        ];
    }
}
