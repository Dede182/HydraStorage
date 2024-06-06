<?php

namespace HydraStorage\HydraStorage\Service\Option;

trait MediaDimension {

    public function setOriginal(): array {
        return [
            'size' => 'original',
            'quality' => 100,
            'width' => null,
            'height' => null,
            'extension' => null
        ];

    }

    public function setThumbnail() {
        return (new self('thumbnail', 100, 100, 100, 'jpg'));
    }

    public function setSmall() {
        return (new self('small', 100, 200, 200, 'jpg'));
    }

    public function setMedium() {
        return (new self('medium', 100, 400, 400, 'jpg'));
    }

    public function setLarge() {
        return (new self('large', 100, 800, 800, 'jpg'));
    }

    public function setExtraLarge() {
        return (new self('extra-large', 100, 1600, 1600, 'jpg'));
    }

    public function setCustom(int $quality, int $width, int $height, string $extension) {
        return (new self('custom', $quality, $width, $height, $extension));
    }
}
