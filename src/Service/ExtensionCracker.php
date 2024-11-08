<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Contracts\ExtensionCrackInterface;

class ExtensionCracker implements ExtensionCrackInterface
{
    public static function getExtension(mixed $file): string
    {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            return self::getExtensionFromUploadedFile($file);
        } else {
            return self::getExtensionFromPath($file);
        }
    }

    public static function getExtensionFromUploadedFile(mixed $file): string
    {
        return $file->getClientOriginalExtension();
    }

    public static function getExtensionFromPath(mixed $file): string
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}
