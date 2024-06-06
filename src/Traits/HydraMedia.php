<?php

namespace HydraStorage\HydraStorage\Traits;

use HydraStorage\HydraStorage\Contracts\HydraMediaInteface;
use HydraStorage\HydraStorage\Service\Option\MediaOption;

trait HydraMedia
{
    protected $defaultDisk = '';

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false, ?MediaOption $mediaOption = null)
    {
        $media = app(HydraMediaInteface::class)->setOption($mediaOption);
        $mediaStore = $media->storeMedia($file, $folderPath, $compression);

        return $mediaStore;

    }
}
