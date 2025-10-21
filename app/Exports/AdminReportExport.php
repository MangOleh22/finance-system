<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        if ($this->type === 'transactions') {
            return Transaction::with('user')->orderBy('date', 'desc')->get();
        } elseif ($this->type === 'users') {
            return User::all();
        }

        return collect([]);
    }

    public function headings(): array
    {
        if ($this->type === 'transactions') {
            return ['ID', 'User', 'Tanggal', 'Tipe', 'Kategori', 'Jumlah', 'Deskripsi'];
        } elseif ($this->type === 'users') {
            return ['ID', 'Username', 'Email', 'Role', 'Dibuat Pada'];
        }

        return [];
    }

    public function map($row): array
    {
        if ($this->type === 'transactions') {
            return [
                $row->id,
                $row->user->username,
                $row->date->format('Y-m-d'),
                $row->type,
                $row->category,
                $row->amount,
                $row->description,
            ];
        } elseif ($this->type === 'users') {
            return [
                $row->id,
                $row->username,
                $row->email,
                $row->role,
                $row->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return [];
    }
}
