<?php

namespace HydraStorage\HydraStorage\Service\StorageStrategy;

use HydraStorage\HydraStorage\Contracts\StorageStrategy;
use HydraStorage\HydraStorage\Service\ImageDriverFactory;
use HydraStorage\HydraStorage\Service\ImageManipulation;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Service\WebpEncoderFactory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;

class CompressedStorageStrategy implements StorageStrategy
{
    protected MediaOption $mediaOption;

    protected bool $webp;

    public function __construct(MediaOption $mediaOption)
    {
        $this->webp = $mediaOption->wantsWebpOutput();

        // Clone the MediaOption to avoid mutating the original instance
        $this->mediaOption = clone $mediaOption;
        $this->mediaOption = $this->mutateMediaOption($this->mediaOption);
    }

    public function store(mixed $file, string $folderPath, string $fileName): string
    {
        $disk = config('hydrastorage.provider');

        $compressedFile = ImageManipulation::manipulate($file, $this->mediaOption);

        Storage::disk($disk)->put(
            $folderPath.'/'.$fileName,
            $this->normalizeForStorage($compressedFile)
        );

        return $fileName;
    }

    protected function normalizeForStorage(mixed $contents): string
    {
        if ($contents instanceof Image) {
            if ($this->webp && ImageDriverFactory::supportsWebp()) {
                return $contents->encode(WebpEncoderFactory::make())->toString();
            }

            return $contents->encode(new AutoEncoder)->toString();
        }

        if ($contents instanceof EncodedImageInterface) {
            return $contents->toString();
        }

        return (string) $contents;
    }

    protected function mutateMediaOption(MediaOption $mediaOption): MediaOption
    {
        $invalidOptions = ['prefix', 'webp'];

        $mediaOption->type = array_filter($mediaOption->type, function ($option) use ($invalidOptions) {
            return ! in_array($option['type'], $invalidOptions);
        });

        $mediaOption->orderOperations();

        return $mediaOption;
    }
}
