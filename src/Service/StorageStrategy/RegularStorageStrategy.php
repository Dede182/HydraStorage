<?php
namespace HydraStorage\HydraStorage\Service\StorageStrategy;

use HydraStorage\HydraStorage\Contracts\StorageStrategy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

class RegularStorageStrategy implements StorageStrategy
{
    public function store(mixed $file, string $folderPath, string $fileName): string
    {
        // Get the storage disk configuration
        $disk = config('hydrastorage.provider');

        // Initialize fileContent as null
        $fileContent = null;

        // Check if $file is an instance of UploadedFile
        if ($file instanceof UploadedFile) {
            // Try to handle the file even if it fails the isValid check
            if (!$file->isValid()) {
                // Get file extension and MIME type to handle cases where it's an unknown type
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();

                // Allow for specific extensions or MIME types
                if ($extension === 'gif' && $mimeType === 'application/octet-stream') {
                    // Special handling for CCStream or non-standard GIF files
                    $fileContent = file_get_contents($file->getPathname());
                } else {
                    throw new Exception("Unsupported file type: " . $mimeType);
                }
            } else {
                // Valid file, proceed normally
                $fileContent = $file->get();
            }
        } elseif (is_string($file) && file_exists($file)) {
            // If $file is a valid file path, use file_get_contents
            $fileContent = file_get_contents($file);
        } else {
            // If neither, throw an exception or handle the error
            throw new Exception("Invalid file provided. File does not exist at the provided path.");
        }

        // Store the file on the configured disk
        Storage::disk($disk)->put($folderPath . '/' . $fileName, $fileContent);

        return $fileName;
    }
}
