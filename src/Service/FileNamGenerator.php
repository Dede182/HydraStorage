<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\FileNameGeneratorInterface;
use HydraStorage\HydraStorage\Service\Option\MediaOption;

class FileNamGenerator implements FileNameGeneratorInterface
{
    public static function generate(mixed $file, string $extension,MediaOption $mediaOption) : mixed
    {

        $get_name = $file->getClientOriginalName();

        $file_name = str_replace(' ', '_', $get_name);

        $exploded = explode('.', $file_name);

        array_pop($exploded);

        $file_name = implode('.', $exploded);

        $prefix = array_filter($mediaOption->type, function ($value) {
            return $value['type'] == 'prefix';
        });

        if (count($prefix) > 0) {
            foreach ($prefix as $value) {
                $file_name = $value['value'] . '_' . $file_name;
            }
        }

        return $file_name .'.'. $extension;
    }
}
