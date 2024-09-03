<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\HydraMediaInterface;
use HydraStorage\HydraStorage\Contracts\StorageStrategy;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Service\StorageStrategy\CompressedStorageStrategy;
use HydraStorage\HydraStorage\Service\StorageStrategy\RegularStorageStrategy;
use Illuminate\Support\Facades\Storage;

class HydraStore implements HydraMediaInterface
{
    protected MediaOption $mediaOption;
    protected string $mainPath = 'public/';
    protected StorageStrategy $storageStrategy;

    public function __construct(?MediaOption $mediaOption = null)
    {
        $this->mediaOption = $mediaOption ?? resolve(MediaOption::class);
    }

    public function setProvider(?string $provider): self
    {
        config(['hydrastorage.provider' => $provider ?? config('hydrastorage.provider')]);
        return $this;
    }

    public function setOption(MediaOption $mediaOption): self
    {
        $this->mediaOption = $mediaOption;
        return $this;
    }

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false): string|array
    {
        $this->storageStrategy = $this->getStorageStrategy($compression);

        $this->createStorageFolder($folderPath);

        if (is_array($file)) {
            return $this->processBatch($file, $folderPath);
        }

        return $this->storeSingleMedia($file, $folderPath);
    }

    protected function processBatch(array $files, string $folderPath): array
    {
        return array_map(fn($media) => $this->storeSingleMedia($media, $folderPath), $files);
    }

    protected function storeSingleMedia(mixed $file, string $folderPath): string
    {
        $extension = ExtensionCracker::getExtension($file);
        $fileName = FileNamGenerator::generate($file, $extension, $this->mediaOption);

        return $this->storageStrategy->store($file, $this->mainPath . $folderPath, $fileName);
    }

    protected function createStorageFolder(string $folderPath): void
    {
        $storagePath = $this->mainPath . $folderPath;
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath, 0755, true);
        }
    }

    protected function getStorageStrategy(bool $compression): StorageStrategy
    {
        if ($compression) {
            return new CompressedStorageStrategy(clone $this->mediaOption); // Clone for immutability
        }

        return new RegularStorageStrategy();
    }
}
