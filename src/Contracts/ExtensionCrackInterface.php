<?php

namespace HydraStorage\HydraStorage\Contracts;

interface ExtensionCrackInterface
{
    public static function getExtension(mixed $file): string;
}
