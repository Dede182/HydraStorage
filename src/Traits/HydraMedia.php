<?php

namespace HydraStorage\HydraStorage\Traits;

use HydraStorage\HydraStorage\Contracts\HydraMediaInteface;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

trait HydraMedia
{

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false, ?MediaOption $mediaOption = null)
    {
        $mediaOption = $mediaOption ?? app('mediaOption');
        $media = app(HydraMediaInteface::class)->setOption($mediaOption);
        $mediaStore = $media->storeMedia($file, $folderPath, $compression);

        return $mediaStore;
    }

    public function removeMedia(string $path)
    {
        $disk = config('hydrastorage.provider');

        Storage::disk($disk)->delete($path);

        return true;
    }
}
