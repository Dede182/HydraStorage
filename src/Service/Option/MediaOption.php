<?php

namespace HydraStorage\HydraStorage\Service\Option;

/**
 * MediaOption
 */
class MediaOption
{
    use MediaDimension;

    public ?string $size;

    public ?int $quality = 100;

    public ?int $width = null;

    public ?int $height = null;

    public ?string $extension = null;

    public function __construct(?string $size = null, int $quality = 100, ?int $width = null, ?int $height = null, ?string $extension = null)
    {
        $this->size = $size;

        $this->quality = $quality;
        $this->width = $width;
        $this->height = $height;
        $this->extension = $extension;
    }

    public function get()
    {
        return $this;
    }
}
