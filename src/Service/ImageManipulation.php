<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Expections\InvalidInputMediaFormat;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Service\Snap\ImageSnap;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ImageManipulation
{
    public static $mediaOption;

    public function __construct() {}

    public static function manipulate(mixed $file, MediaOption $mediaOption)
    {
        self::$mediaOption = $mediaOption;
        (new self)->checkExtension($file);

        try {
            return static::process($file);
        } catch (\Exception $e) {
            return $file;
        }

    }

    protected static function process(mixed $file)
    {
        if (is_array($file)) {
            $output = [];
            foreach ($file as $media) {
                $output[] = static::process($media);
            }

            return $output;
        }

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($file);
        return ImageSnap::snap($image, self::$mediaOption->type);
    }

    protected function checkExtension($file): void
    {
        $accept = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        $extension = $file->getClientMimeType();

        $name = $file->getClientOriginalName();

        $message = "$name is  $extension of mimeType, only jpeg, png, jpg, gif are allowed.";

        if (! in_array($extension, $accept)) {
            throw new InvalidInputMediaFormat($message);
        }
    }
}
