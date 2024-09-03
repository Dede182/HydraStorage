<?php

namespace HydraStorage\HydraStorage\Contracts;

use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Interfaces\EncoderInterface;

interface ImageOperationStrategy
{
    public function apply(Image $image, $value): Image |EncodedImageInterface;
}
