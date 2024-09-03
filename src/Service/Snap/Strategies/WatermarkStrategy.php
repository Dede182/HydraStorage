<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Image;

class WatermarkStrategy implements ImageOperationStrategy
{
    public function apply(Image $image, $value): Image
    {
        return $image->place($value['image'], $value['position'], $value['x'] ?? 0, $value['y'] ?? 0,
            $value['opacity'] ?? 100
        );
    }
}
