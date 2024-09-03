<?php

namespace HydraStorage\HydraStorage\Service\Snap\Strategies;

use HydraStorage\HydraStorage\Contracts\ImageOperationStrategy;
use Intervention\Image\Image;

class WatermarkStrategy implements ImageOperationStrategy
{
    public function apply(Image $image, $value): Image
    {
        try{
            return $image->place($value['image'], $value['position'],opacity: $value['opacity']);
        }
        catch (\Exception $e){
            throw new \InvalidArgumentException("Watermark image not found");
        }
    }
}
