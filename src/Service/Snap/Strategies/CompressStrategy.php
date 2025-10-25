<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Drivers\Imagick\Encoders\WebpEncoder;
use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;

class CompressStrategy implements ImageOperationStrategy
{
    public function apply(Image $image,mixed $value): Image|EncodedImageInterface
    {
        $value = $value > 80 ? 80 : $value;
        return $image->encode(new WebpEncoder($value));
    }
}
