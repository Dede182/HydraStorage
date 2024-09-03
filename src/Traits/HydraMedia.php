<?php

namespace HydraStorage\HydraStorage\Traits;

use HydraStorage\HydraStorage\Contracts\HydraMediaInterface;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

trait HydraMedia
{
    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false, ?MediaOption $mediaOption = null, ?string $diskProvider = null): string|array
    {
        $mediaOption = $mediaOption ?? app('mediaOption');
        $media = app(HydraMediaInterface::class)->setOption($mediaOption);
        $media->setProvider($diskProvider);
        $mediaStore = $media->storeMedia($file, $folderPath, $compression);

        return $mediaStore;
    }

    public function removeMedia(string $path, $diskProvider = null)
    {

        $disk = $diskProvider ?? config('hydrastorage.provider');

        Storage::disk($disk)->delete($path);

        return true;
    }

    public function getMedia(string $path, string $prefix = '', ?string $diskProvider = null): string
    {
        $disk = $diskProvider ?? config('hydrastorage.provider');

        // Return URL directly if the path is already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Return the correct URL based on the disk
        return $disk === 'local'
            ? asset('storage/'.$path)
            : Storage::disk($disk)->url($prefix.$path);
    }
}
