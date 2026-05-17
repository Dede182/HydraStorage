<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Expections\InvalidInputMediaFormat;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Service\Snap\ImageSnap;

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

        return ImageSnap::snap($file, self::$mediaOption->type);
    }

    protected function checkExtension($file): void
    {
        $accept = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp', 'application/octet-stream'];

        if (is_string($file)) {
            $extension = $file;
            $name = 'file';
        } else {
            $extension = $file->getClientMimeType();
            $name = $file->getClientOriginalName();
        }

        $message = "$name is  $extension of mimeType, only jpeg, png, jpg, gif, and webp are allowed.";

        if (! in_array($extension, $accept)) {
            throw new InvalidInputMediaFormat($message);
        }
    }
}
