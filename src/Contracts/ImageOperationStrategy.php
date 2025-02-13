<?php

namespace HydraStorage\HydraStorage\Contracts;

use Intervention\Image\Image;
use Intervention\Image\Interfaces\EncodedImageInterface;

interface ImageOperationStrategy
{
    public function apply(Image $image,mixed $value): Image|EncodedImageInterface;
}
