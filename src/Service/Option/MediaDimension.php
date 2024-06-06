<?php

namespace HydraStorage\HydraStorage\Service\Option;

trait MediaDimension
{
    public function setOriginal(): self
    {
        return new self("original", 100, null, null, null);
    }

    public function setThumbnail() : self
    {
        return new self('thumbnail', 80, 150, 150, 'jpg');
    }

    public function setSmall() : self
    {
        return new self('small', 100, 200, 200, 'jpg');
    }

    public function setMedium() : self
    {
        return new self('medium', 100, 400, 400, 'jpg');
    }

    public function setLarge() : self
    {
        return new self('large', 100, 800, 800, 'jpg');
    }

    public function setExtraLarge() : self
    {
        return new self('extra-large', 100, 1600, 1600, 'jpg');
    }

    public function setCustom(int $quality, int $width, int $height, string $extension) : self
    {
        return new self('custom', $quality, $width, $height, $extension);
    }
}
