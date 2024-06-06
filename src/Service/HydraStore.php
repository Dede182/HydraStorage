<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

class HydraStore
{
    protected $mediaOption;

    protected $mainPath = 'public/';

    public function __construct(MediaOption $mediaOption)
    {
        $this->mediaOption = $mediaOption ;
    }

    public function storeMedia(mixed $file, string $folderPath = 'media', bool $compression = false)
    {
        $mediaCollection = $compression ? $this->manipulate($file) : $file;


        $this->createStorageFolder($folderPath);

        $output = [];

        if (is_array($mediaCollection)) {
            foreach ($mediaCollection as $media) {
                $extension = ExtensionCracker::getExtension($media);

                $file_name = FileNamGenerator::generate($media, $extension);

                $output[] =   $this->store($folderPath, $media,$file_name,$compression);
            }
        } else {
            $extension = ExtensionCracker::getExtension($mediaCollection);

            $file_name = FileNamGenerator::generate($mediaCollection, $extension);
            return $this->store($folderPath, $mediaCollection,$file_name,$compression);
        }

        return $output;
    }

    protected function manipulate(mixed $file)
    {
        return ImageManipulation::manipulate($file,$this->mediaOption);
    }


    protected function store(string $path, mixed $file ,string $file_name,bool $copressed = false)
    {
        $disk = config('hydrastorage.provider');

        if(!$copressed)
        {
            $file = file_get_contents($file);
        }

        Storage::disk($disk)->put($this->mainPath.$path.'/'.$file_name, $file);

        return $file_name;
    }

    protected function createStorageFolder(string $folderPath)
    {
        if (! Storage::exists($this->mainPath.$folderPath)) {
            Storage::makeDirectory($this->mainPath.$folderPath, 0755, true);
        }
    }
}
