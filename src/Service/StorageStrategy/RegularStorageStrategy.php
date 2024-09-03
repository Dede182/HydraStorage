<?php

namespace HydraStorage\HydraStorage\Service\StorageStrategy;

use HydraStorage\HydraStorage\Contracts\StorageStrategy;
use Illuminate\Support\Facades\Storage;

class RegularStorageStrategy implements StorageStrategy
{
    public function store(mixed $file, string $folderPath, string $fileName): string
    {
        $disk = config('hydrastorage.provider');
        $fileContent = is_string($file) ? file_get_contents($file) : $file;

        Storage::disk($disk)->put($folderPath.'/'.$fileName, $fileContent);

        return $fileName;
    }
}
