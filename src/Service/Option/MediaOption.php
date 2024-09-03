<?php

namespace HydraStorage\HydraStorage\Service\Option;

/**
 * MediaOption
 */
class MediaOption
{
    public array $type = [];

    public function __construct() {}

    public static function create()
    {
        return new self;
    }

    public function get()
    {
        return $this;
    }

    public function setExtension(string $extension)
    {
        $this->type[] = [
            'type' => 'extension',
            'value' => $extension,
        ];

        return $this;
    }

    public function setQuality(int $quality)
    {
        $this->type[] = [
            'type' => 'compress',
            'value' => $quality,
        ];

        return $this;
    }

    public function grayscale()
    {
        $this->type[] = [
            'type' => 'grayscale',
            'value' => true,
        ];

        return $this;
    }

    public function setWaterMark(mixed $image, $position = 'center', $opacity = 100)
    {

        $this->type[] = [
            'type' => 'watermark',
            'value' => [
                'image' => $image,
                'position' => $position ?? 'center',
                'opacity' => $opacity ?? 100,
            ],
        ];

        return $this;
    }

    public function setPrefixFileName(string $prefix)
    {
        $this->type[] = [
            'type' => 'prefix',
            'value' => $prefix,
        ];

        return $this;
    }

    public function resize(?string $recommand, ?int $width = 350, ?int $height = 350)
    {

        // if recommand is not null, set width and height to null
        match ($recommand) {
            'thumbnail' => [$width, $height] = [150, 150],
            'small' => [$width, $height] = [300, 300],
            'medium' => [$width, $height] = [600, 600],
            'large' => [$width, $height] = [800, 800],
            default => [$width, $height] = [$width, $height]
        };

        $this->type[] = [
            'type' => 'resize',
            'value' => [
                'width' => $width,
                'height' => $height,
            ],
        ];

        return $this;
    }
}
