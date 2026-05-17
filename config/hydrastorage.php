<?php

// config for HydraStorage/HydraStorage
return [

    'provider' => env('STORAGE_PROVIDER', 'local'),

    'compressed_quality' => env('COMPRESSED_QUALITY', 60),

    'public_prefix' => false,

    /*
    |--------------------------------------------------------------------------
    | Image driver
    |--------------------------------------------------------------------------
    |
    | Supported: "auto", "imagick", "gd"
    | "auto" uses Imagick when the extension is loaded, otherwise GD.
    |
    */
    'image_driver' => env('HYDRA_IMAGE_DRIVER', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Save as WebP
    |--------------------------------------------------------------------------
    |
    | When true, compressed uploads are encoded and stored as .webp files.
    | Can be overridden per upload via MediaOption::webp().
    |
    */
    'save_as_webp' => env('HYDRA_SAVE_AS_WEBP', false),

    /*
    |--------------------------------------------------------------------------
    | WebP quality
    |--------------------------------------------------------------------------
    |
    | Quality for WebP encoding (1–100). Lower = smaller files.
    | Falls back to compressed_quality when null.
    |
    */
    'webp_quality' => env('HYDRA_WEBP_QUALITY'),

    /*
    |--------------------------------------------------------------------------
    | WebP strip metadata
    |--------------------------------------------------------------------------
    |
    | Remove EXIF/metadata from WebP output for smaller file size.
    |
    */
    'webp_strip_metadata' => env('HYDRA_WEBP_STRIP_METADATA', true),
];
