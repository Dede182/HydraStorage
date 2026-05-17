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

    public function setWaterMark(mixed $image, string $position = 'center', int $opacity = 100)
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

    public function webp(?bool $enabled = true): static
    {
        $this->type[] = [
            'type' => 'webp',
            'value' => $enabled,
        ];

        return $this;
    }

    /**
     * Optimize for lightweight storage: WebP at configured quality (default 60).
     * Combine with resize() for maximum savings on large uploads.
     */
    public function lightweight(?int $quality = null): static
    {
        return $this->setQuality(
            $quality ?? (int) (config('hydrastorage.webp_quality') ?? config('hydrastorage.compressed_quality', 60))
        );
    }

    public function wantsWebpOutput(): bool
    {
        $webpOptions = array_filter($this->type, fn ($option) => $option['type'] === 'webp');

        if (count($webpOptions) > 0) {
            return (bool) end($webpOptions)['value'];
        }

        return (bool) config('hydrastorage.save_as_webp', false);
    }

    public function isCompressed(): bool
    {
        return count(array_filter($this->type, fn ($option) => $option['type'] === 'compress')) > 0;
    }

    public function shouldUseWebpExtension(): bool
    {
        return $this->isCompressed() || $this->wantsWebpOutput();
    }

    public function orderOperations(): array
    {
        $lastOperationType = 'compress';

        $lastOperations = array_filter($this->type, fn ($option) => $option['type'] === $lastOperationType);
        $otherOperations = array_filter($this->type, fn ($option) => $option['type'] !== $lastOperationType);

        $this->type = array_merge($otherOperations, $lastOperations);

        return $this->type;
    }
}
