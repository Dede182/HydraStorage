<?php

namespace HydraStorage\HydraStorage\Service\Option;

/**
 * MediaOption
 */
class MediaOption
{
    public ?string $size;

    public ?int $quality;

    public ?int $width;

    public ?int $height;



    public function __construct(string $size = null, int $quality = 100, int $width = null, int $height = null)
    {
        $this->size = $size;
        $this->quality = $quality;
        $this->width = $width;
        $this->height = $height;
    }

    public function get(): array
    {
        return [
            'size' => $this->size,
            'quality' => $this->quality,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

}
