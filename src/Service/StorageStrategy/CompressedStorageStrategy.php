<?php

namespace HydraStorage\HydraStorage\Service\StorageStrategy;

use HydraStorage\HydraStorage\Contracts\StorageStrategy;
use HydraStorage\HydraStorage\Service\ImageManipulation;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

class CompressedStorageStrategy implements StorageStrategy
{
    protected MediaOption $mediaOption;

    public function __construct(MediaOption $mediaOption)
    {
        // Clone the MediaOption to avoid mutating the original instance
        $this->mediaOption = clone $mediaOption;
        $this->mediaOption = $this->mutateMediaOption($this->mediaOption);
    }

    public function store(mixed $file, string $folderPath, string $fileName): string
    {
        $disk = config('hydrastorage.provider');
        $compressedFile = ImageManipulation::manipulate($file, $this->mediaOption);

        Storage::disk($disk)->put($folderPath.'/'.$fileName, $compressedFile);

        return $fileName;
    }

    protected function mutateMediaOption(MediaOption $mediaOption): MediaOption
    {
        $invalidOptions = ['prefix'];

        $mediaOption->type = array_filter($mediaOption->type, function ($option) use ($invalidOptions) {
            return ! in_array($option['type'], $invalidOptions);
        });

        return $mediaOption;
    }
}
