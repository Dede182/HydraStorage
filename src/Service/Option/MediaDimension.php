<?php

namespace HydraStorage\HydraStorage\Service\Option;

trait MediaDimension
{
    public function setOriginal(): self
    {
        return new self('original', 100, null, null, null);
    }

    public function setPreview(): self
    {
        return new self('preview', 60, 80, 80, 'jpg');
    }

    public function setThumbnail(): self
    {
        return new self('thumbnail', 80, 150, 150, 'jpg');
    }

    public function setSmall(): self
    {
        return new self('small', 100, 200, 200, 'jpg');
    }

    public function setMedium(): self
    {
        return new self('medium', 100, 400, 400, 'jpg');
    }

    public function setLarge(): self
    {
        return new self('large', 100, 800, 800, 'jpg');
    }

    public function setExtraLarge(): self
    {
        return new self('extra-large', 100, 1600, 1600, 'jpg');
    }

    public function setBanner(): self
    {
        return new self('banner', 100, 1920, 1080, 'jpg');
    }

    public function setLogo(int $width = 200,int $height = 200): self
    {
        return new self('logo', 100, $width, $height, 'png');
    }

    public function setCustom(int $quality, ?int $width = null, ?int $height = null, string $extension): self
    {
        return new self('custom', $quality, $width, $height, $extension);
    }
}
