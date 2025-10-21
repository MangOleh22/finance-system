<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct($userId, $startDate = null, $endDate = null)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Transaction::where('user_id', $this->userId);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Tipe',
            'Kategori',
            'Jumlah',
            'Deskripsi',
            'Dibuat Pada',
        ];
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
            $transaction->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
