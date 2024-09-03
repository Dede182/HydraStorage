<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;

class CompressStrategy implements ImageOperationStrategy
{
    public function apply(Image $image, $value): Image|EncodedImageInterface
    {
        return $image->encode(new AutoEncoder(quality: $value));
    }
}
