<?php

namespace HydraStorage\HydraStorage\Contracts;

interface StorageStrategy
{
    public function store(mixed $file, string $folderPath, string $fileName): string;

}
