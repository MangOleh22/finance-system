<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FullBackupExport;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('local')->files('backups');
        $backups = array_map(function($file) {
            return [
                'name' => basename($file),
                'size' => Storage::disk('local')->size($file),
                'date' => Storage::disk('local')->lastModified($file),
            ];
        }, $backups);

        return view('admin.backup.index', compact('backups'));
    }

    public function create($type)
    {
        $filename = 'backup-' . $type . '-' . date('Y-m-d-His');

        if ($type === 'database') {
            // Database backup
            Artisan::call('backup:run', ['--only-db' => true]);
            $message = 'Database backup berhasil dibuat.';
        } else {
            // Full backup
            Artisan::call('backup:run');
            $message = 'Full backup berhasil dibuat.';
        }

        return back()->with('success', $message);
    }

    public function download($filename)
    {
        $path = 'backups/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        return Storage::disk('local')->download($path);
    }

    public function destroy($filename)
    {
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return back()->with('success', 'Backup berhasil dihapus.');
        }

        return back()->with('error', 'File backup tidak ditemukan.');
    }

    public function export($type, $format)
    {
        $filename = 'export-' . $type . '-' . date('Y-m-d-His') . '.' . $format;

        return Excel::download(
            new FullBackupExport($type),
            $filename
        );
    }
}
