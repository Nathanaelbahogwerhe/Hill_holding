<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    /**
     * Upload un ou plusieurs fichiers
     *
     * @param UploadedFile|array $files
     * @param string $directory
     * @return array|string
     */
    public function uploadFiles($files, string $directory = 'uploads')
    {
        if (is_array($files)) {
            $uploadedFiles = [];
            foreach ($files as $file) {
                $uploadedFiles[] = $this->uploadSingleFile($file, $directory);
            }
            return $uploadedFiles;
        }

        return $this->uploadSingleFile($files, $directory);
    }

    /**
     * Upload un fichier unique
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    private function uploadSingleFile(UploadedFile $file, string $directory): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        
        return [
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $path,
            'url' => Storage::url($path),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Supprimer un ou plusieurs fichiers
     *
     * @param string|array $paths
     * @return bool
     */
    public function deleteFiles($paths): bool
    {
        if (is_string($paths)) {
            $paths = [$paths];
        }

        foreach ($paths as $path) {
            if (is_array($path) && isset($path['path'])) {
                $path = $path['path'];
            }
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return true;
    }

    /**
     * Télécharger un fichier
     *
     * @param string|array $fileData
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile($fileData)
    {
        if (is_array($fileData)) {
            $path = $fileData['path'] ?? null;
            $originalName = $fileData['original_name'] ?? 'download';
        } else {
            $path = $fileData;
            $originalName = basename($path);
        }

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download($path, $originalName);
    }

    /**
     * Fusionner les anciens et nouveaux attachments
     *
     * @param array|null $oldAttachments
     * @param array|null $newFiles
     * @param string $directory
     * @return array
     */
    public function mergeAttachments(?array $oldAttachments, ?array $newFiles, string $directory = 'uploads'): array
    {
        $attachments = $oldAttachments ?? [];

        if ($newFiles) {
            $uploaded = $this->uploadFiles($newFiles, $directory);
            if (is_array($uploaded) && !isset($uploaded['path'])) {
                // Multiple files
                $attachments = array_merge($attachments, $uploaded);
            } else {
                // Single file
                $attachments[] = $uploaded;
            }
        }

        return $attachments;
    }

    /**
     * Supprimer un fichier spécifique des attachments
     *
     * @param array $attachments
     * @param int $index
     * @return array
     */
    public function removeAttachment(array $attachments, int $index): array
    {
        if (isset($attachments[$index])) {
            $this->deleteFiles($attachments[$index]);
            unset($attachments[$index]);
        }

        return array_values($attachments); // Réindexer le tableau
    }
}
