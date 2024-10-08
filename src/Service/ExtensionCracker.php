<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\ExtensionCrackInterface;

class ExtensionCracker implements ExtensionCrackInterface
{
    public static function getExtension(mixed $file): string
    {
        // the interfacen of file

        if ($file instanceof \Illuminate\Http\UploadedFile) {
            return self::getExtensionFromUploadedFile($file);
        } else {
            return self::getExtensionFromPath($file);
        }

    }

    public static function onlyExtension(string $extension)
    {
        $exploded = explode('/', $extension);

        return end($exploded);
    }

    public static function getExtensionFromUploadedFile(mixed $file): string
    {
        return $file->getClientOriginalExtension();
    }

    public static function getExtensionFromPath(mixed $file): string
    {
        // dd($file->exif());
        // dd(get_class_methods($file));
        return 'jpg';
    }
}
