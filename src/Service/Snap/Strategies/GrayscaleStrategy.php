<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Image;

class GrayscaleStrategy implements ImageOperationStrategy
{
    public function apply(Image $image,mixed $value): Image
    {
        return $image->greyscale();
    }
}
