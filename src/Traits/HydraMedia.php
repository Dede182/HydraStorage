<?php

namespace HydraStorage\HydraStorage\Traits;

use HydraStorage\HydraStorage\Service\HydraStore;
use HydraStorage\HydraStorage\Service\Option\MediaOption;

trait HydraMedia
{
    protected $defaultDisk = '';

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false)
    {
        $mediaOption = new MediaOption('high', 400, 400, 400);
        $mediaStore = (new HydraStore($mediaOption))->storeMedia($file, $folderPath, $compression);

        return $mediaStore;

    }
}
