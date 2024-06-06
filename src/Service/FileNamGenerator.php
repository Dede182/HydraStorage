<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\FileNameGeneratorInterface;

class FileNamGenerator implements FileNameGeneratorInterface
{
    public static function generate(mixed $file, string $extension): mixed
    {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $get_name = $file->getClientOriginalName();
        } else {
            $get_name = $file->mimeType();
        }

        $file_name = time().str_replace(' ', '_', $get_name);

        // explode with . and then remove last and then concat with extension
        $exploded = explode('/', $file_name);

        // remove last element
        array_pop($exploded);

        // convert into string
        $file_name = implode('.', $exploded);

        return $file_name.'.'.$extension;
    }
}
