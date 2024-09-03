<?php

namespace HydraStorage\HydraStorage\Service\Snap;

use HydraStorage\HydraStorage\Service\Snap\Strategies\CompressStrategy;
use HydraStorage\HydraStorage\Service\Snap\Strategies\GrayscaleStrategy;
use HydraStorage\HydraStorage\Service\Snap\Strategies\ResizeStrategy;
use HydraStorage\HydraStorage\Service\Snap\Strategies\WatermarkStrategy;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImageSnap
{
    protected static array $strategies = [
        'compress' => CompressStrategy::class,
        'grayscale' => GrayscaleStrategy::class,
        'resize' => ResizeStrategy::class,
        'watermark' => WatermarkStrategy::class,
    ];

    public static function snap($image, array $mediaOptions)
    {
        $image = self::convertImageInstance($image);

        foreach ($mediaOptions as $option) {
            $type = $option['type'];
            $value = $option['value'];

            if (isset(self::$strategies[$type])) {
                $strategy = new self::$strategies[$type];
                $image = $strategy->apply($image, $value);
            } else {
                throw new \InvalidArgumentException("Unsupported media option: $type");
            }
        }

        return $image;
    }

    public static function convertImageInstance($image): Image
    {
        if ($image instanceof Image) {
            return $image;
        }

        $manager = new ImageManager(Driver::class); // or 'gd'

        return $manager->read($image);
    }
}
