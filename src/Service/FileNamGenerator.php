<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\FileNameGeneratorInterface;

class FileNamGenerator implements FileNameGeneratorInterface
{
    public static function generate(mixed $file, string $extension): mixed
    {
        $get_name = $file->getClientOriginalName();

        $file_name = str_replace(' ', '_', $get_name);

        $exploded = explode('.', $file_name);

        array_pop($exploded);

        $file_name = implode('.', $exploded);

        return $file_name.'.'.$extension;
    }
}
