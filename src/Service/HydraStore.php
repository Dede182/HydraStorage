<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\HydraMediaInteface;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

class HydraStore implements HydraMediaInteface
{
    protected $mediaOption;

    protected $mainPath = 'public/';

    public function __construct(?MediaOption $mediaOption)
    {
        $this->mediaOption = $mediaOption ?? app('mediaOption');
    }

    public function setOption(MediaOption $mediaOption): self
    {
        $this->mediaOption = $mediaOption;

        return $this;
    }

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false): string|array
    {
        $mediaCollection = $file;
        $this->createStorageFolder($folderPath);

        $output = [];

        if (is_array($mediaCollection)) {
            foreach ($mediaCollection as $media) {

                $sub_media = $compression ? $this->manipulate($media) : $media;

                $extension = ExtensionCracker::getExtension($sub_media);
                $file_name = FileNamGenerator::generate($media, $extension,$this->mediaOption);

                $output[] = $this->store($folderPath, $sub_media, $file_name, $compression);
            }
        } else {

            $mediaCollection = $compression ? $this->manipulate($mediaCollection) : $mediaCollection;

            $extension = ExtensionCracker::getExtension($mediaCollection);

            $file_name = FileNamGenerator::generate($file, $extension,$this->mediaOption);

            return $this->store($folderPath, $mediaCollection, $file_name, $compression);
        }

        return $output;
    }

    protected function manipulate(mixed $file)
    {
        return ImageManipulation::manipulate($file, $this->mediaOption);
    }

    protected function store(string $path, mixed $file, string $file_name, bool $copressed = false): string
    {
        $disk = config('hydrastorage.provider');

        if (! $copressed) {
            $file = file_get_contents($file);
        }

        Storage::disk($disk)->put($this->mainPath.$path.'/'.$file_name, $file);

        return $file_name;
    }

    protected function createStorageFolder(string $folderPath): void
    {
        if (! Storage::exists($this->mainPath.$folderPath)) {
            Storage::makeDirectory($this->mainPath.$folderPath, 0755, true);
        }
    }
}
