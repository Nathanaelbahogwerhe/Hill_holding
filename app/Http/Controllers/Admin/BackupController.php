<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemBackup;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        $backups = SystemBackup::with('creator')->latest()->paginate(15);

        return view('admin.backups.index', compact('backups'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required|in:full,database,files',
        ]);

        $filename = 'backup-' . $request->type . '-' . date('Y-m-d-His') . '.zip';
        
        $backup = SystemBackup::create([
            'filename' => $filename,
            'type' => $request->type,
            'created_by' => auth()->id(),
            'status' => 'pending',
        ]);

        try {
            // Create backup directory if not exists
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $fullPath = $backupPath . '/' . $filename;
            
            if ($request->type === 'database') {
                $this->createDatabaseBackup($fullPath);
            } elseif ($request->type === 'files') {
                $this->createFilesBackup($fullPath);
            } else {
                $this->createFullBackup($fullPath);
            }

            $backup->update([
                'status' => 'completed',
                'size' => file_exists($fullPath) ? filesize($fullPath) : 0,
            ]);

            ActivityLog::log('backup_created', "Backup created: $filename");

            return redirect()->route('admin.backups.index')->with('success', 'Backup créé avec succès');
            
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return redirect()->route('admin.backups.index')->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function download(SystemBackup $backup)
    {
        $filePath = storage_path('app/backups/' . $backup->filename);
        
        if (!file_exists($filePath)) {
            return redirect()->route('admin.backups.index')->with('error', 'Fichier introuvable');
        }

        ActivityLog::log('backup_downloaded', "Downloaded backup: {$backup->filename}");

        return response()->download($filePath);
    }

    public function destroy(SystemBackup $backup)
    {
        $filePath = storage_path('app/backups/' . $backup->filename);
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $backup->delete();
        
        ActivityLog::log('backup_deleted', "Deleted backup: {$backup->filename}");

        return redirect()->route('admin.backups.index')->with('success', 'Backup supprimé');
    }

    private function createDatabaseBackup($path)
    {
        // Execute mysqldump
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $sqlFile = str_replace('.zip', '.sql', $path);
        
        $command = "mysqldump -h {$dbHost} -u {$dbUser} -p{$dbPass} {$dbName} > {$sqlFile}";
        exec($command);

        // Zip the SQL file
        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, basename($sqlFile));
            $zip->close();
            unlink($sqlFile);
        }
    }

    private function createFilesBackup($path)
    {
        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE) === TRUE) {
            $this->addDirectoryToZip($zip, storage_path('app'), 'storage');
            $this->addDirectoryToZip($zip, public_path('uploads'), 'public/uploads');
            $zip->close();
        }
    }

    private function createFullBackup($path)
    {
        // First create database backup
        $this->createDatabaseBackup($path);
        
        // Then add files to the same zip
        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE) === TRUE) {
            $this->addDirectoryToZip($zip, storage_path('app'), 'storage');
            $this->addDirectoryToZip($zip, public_path('uploads'), 'public/uploads');
            $zip->close();
        }
    }

    private function addDirectoryToZip($zip, $directory, $localPath = '')
    {
        if (!is_dir($directory)) return;
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) continue;
            
            $filePath = $file->getPathname();
            $relativePath = $localPath . '/' . substr($filePath, strlen($directory) + 1);
            
            $zip->addFile($filePath, $relativePath);
        }
    }
}
