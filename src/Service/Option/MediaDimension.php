<?php

namespace HydraStorage\HydraStorage\Service\Option;

trait MediaDimension
{
    public static function setOriginal(): self
    {
        return new self('original', 100, null, null, null);
    }

    public static function setPreview(): self
    {
        return new self('preview', 60, 80, 80, 'jpg');
    }

    public static function setThumbnail(): self
    {
        return new self('thumbnail', 80, 150, 150, 'jpg');
    }

    public static function setSmall(): self
    {
        return new self('small', 100, 200, 200, 'jpg');
    }

    public static function setMedium(): self
    {
        return new self('medium', 100, 400, 400, 'jpg');
    }

    public static function setLarge(): self
    {
        return new self('large', 100, 800, 800, 'jpg');
    }

    public static function setExtraLarge(): self
    {
        return new self('extra-large', 100, 1600, 1600, 'jpg');
    }

    public static function setBanner(): self
    {
        return new self('banner', 100, 1920, 1080, 'jpg');
    }

    public static function setLogo(int $width = 200, int $height = 200): self
    {
        return new self('logo', 100, $width, $height, 'png');
    }

    public static function setCustom(int $quality, ?int $width, ?int $height, string $extension): self
    {
        return new self('custom', $quality, $width, $height, $extension);
    }
}
