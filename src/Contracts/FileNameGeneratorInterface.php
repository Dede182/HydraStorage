<?php

namespace HydraStorage\HydraStorage\Contracts;

use HydraStorage\HydraStorage\Service\Option\MediaOption;

interface FileNameGeneratorInterface
{
    public static function generate(mixed $file, string $extension, MediaOption $mediaOption): mixed;
}
