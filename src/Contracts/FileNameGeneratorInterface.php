<?php

namespace HydraStorage\HydraStorage\Contracts;

interface FileNameGeneratorInterface
{
    public static function generate(mixed $file, string $extension): mixed;
}
