<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToModel, WithHeadingRow
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        return new Transaction([
            'user_id' => $this->userId,
            'date' => $row['tanggal'] ?? now(),
            'type' => $row['tipe'] ?? 'Pemasukan',
            'category' => $row['kategori'] ?? 'Umum',
            'amount' => $row['jumlah'] ?? 0,
            'description' => $row['deskripsi'] ?? null,
        ]);
    }
}
