<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use HydraStorage\HydraStorage\Service\WebpEncoderFactory;
use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;

class CompressStrategy implements ImageOperationStrategy
{
    public function apply(Image $image, mixed $value): Image|EncodedImageInterface
    {
        $value = $value > 80 ? 80 : $value;

        return $image->encode(WebpEncoderFactory::make((int) $value));
    }
}
