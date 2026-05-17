<?php

namespace HydraStorage\HydraStorage\Service;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Interfaces\DriverInterface;

class ImageDriverFactory
{
    public static function make(): DriverInterface
    {
        $driver = config('hydrastorage.image_driver', 'auto');

        if ($driver === 'imagick' && extension_loaded('imagick')) {
            return new ImagickDriver;
        }

        if ($driver === 'gd' || ($driver === 'auto' && ! extension_loaded('imagick'))) {
            return new GdDriver;
        }

        if ($driver === 'auto' && extension_loaded('imagick')) {
            return new ImagickDriver;
        }

        return new GdDriver;
    }

    public static function supportsWebp(): bool
    {
        if (extension_loaded('imagick')) {
            return true;
        }

        return function_exists('imagewebp');
    }
}
