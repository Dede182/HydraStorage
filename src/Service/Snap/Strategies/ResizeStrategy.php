<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Image;

class ResizeStrategy implements ImageOperationStrategy
{
    public function apply(Image $image, $value): Image
    {
        return $image->resize($value['width'], $value['height']);
    }
}
