<?php

namespace HydraStorage\HydraStorage\Contracts;

use HydraStorage\HydraStorage\Service\Option\MediaOption;

interface HydraMediaInteface
{
    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false): string|array;

    public function setOption(MediaOption $mediaOption): self;
}
