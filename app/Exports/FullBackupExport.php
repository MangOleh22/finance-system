<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullBackupExport implements WithMultipleSheets
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function sheets(): array
    {
        return [
            new AdminReportExport('transactions'),
            new AdminReportExport('users'),
        ];
    }
}
