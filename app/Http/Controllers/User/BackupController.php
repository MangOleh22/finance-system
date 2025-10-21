<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserDataExport;
use App\Imports\TransactionsImport;

class BackupController extends Controller
{
    public function index()
    {
        return view('user.backup.index');
    }

    public function export(Request $request)
    {
        $userId = auth()->id();
        $type = $request->get('type', 'all');

        $filename = 'backup-' . $type . '-' . date('Y-m-d-His') . '.xlsx';

        return Excel::download(
            new UserDataExport($userId, $type),
            $filename
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'type' => 'required|in:transactions,debts,bank_accounts',
        ]);

        try {
            Excel::import(
                new TransactionsImport(auth()->id()),
                $request->file('file')
            );

            return back()->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }
}
