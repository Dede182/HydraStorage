<?php

namespace HydraStorage\HydraStorage\Service;

use Intervention\Image\Encoders\WebpEncoder;

class WebpEncoderFactory
{
    public static function make(?int $quality = null): WebpEncoder
    {
        $quality ??= config('hydrastorage.webp_quality')
            ?? config('hydrastorage.compressed_quality', 60);

        $strip = (bool) config('hydrastorage.webp_strip_metadata', true);

        return new WebpEncoder((int) $quality, $strip);
    }
}
