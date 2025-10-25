<?php

namespace HydraStorage\HydraStorage\Service\Option;

/**
 * MediaOption
 */
class MediaOption
{
    public array $type = [];

    public function __construct() {}

    public static function create(): MediaOption
    {
        return new self;
    }

    public function get(): static
    {
        return $this;
    }

    public function setExtension(string $extension): static
    {
        $this->type[] = [
            'type' => 'extension',
            'value' => $extension,
        ];

        return $this;
    }

    public function setQuality(int $quality): static
    {
        $this->type[] = [
            'type' => 'compress',
            'value' => $quality,
        ];

        return $this;
    }

    public function grayscale(): static
    {
        $this->type[] = [
            'type' => 'grayscale',
            'value' => true,
        ];

        return $this;
    }

    public function setWaterMark(mixed $image,string $position = 'center',int $opacity = 100)
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

    public function setPrefixFileName(string $prefix): static
    {
        $this->type[] = [
            'type' => 'prefix',
            'value' => $prefix,
        ];

        return $this;
    }

    public function resize(?string $recommand, ?int $width = 350, ?int $height = 350): static
    {
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

    public function isCompressed() : bool
    {
        return count(array_filter($this->type, fn($option) => $option['type'] === 'compress')) > 0;
    }

    public function orderOperations(): array
    {
        $lastOperationType = 'compress';

        $lastOperations = array_filter($this->type, fn($option) => $option['type'] === $lastOperationType);
        $otherOperations = array_filter($this->type, fn($option) => $option['type'] !== $lastOperationType);

        $this->type = array_merge($otherOperations, $lastOperations);
        return $this->type;
    }
}
