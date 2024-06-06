<?php

namespace HydraStorage\HydraStorage\Service;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use HydraStorage\HydraStorage\Service\Option\MediaOption;

class ImageManipulation
{
   public static $mediaOption;

   public function __construct(){
   }

    public static function manipulate(mixed $file,MediaOption $mediaOption)
    {
        self::$mediaOption = $mediaOption;
        return static::process($file);
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

        $image = ImageManager::imagick()->read($file);

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($file);

        $extension = static::getExtension($file);

        return static::resizeAndEncode($image, $extension);
    }

    protected static function getExtension($file)
    {
        $extension = self::$mediaOption->extension ?? $file->getClientOriginalExtension();

        return $extension;
    }

    protected static function resize($image)
    {
        return $image->resize(self::$mediaOption->width, self::$mediaOption->height);
    }

    protected static function resizeAndEncode($image, $extension)
    {
        $image = static::resize($image);
        return $image->encodeByExtension($extension, self::$mediaOption->quality);
    }
}
