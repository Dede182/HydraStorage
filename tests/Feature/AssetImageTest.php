<?php

use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Traits\HydraMedia;
use Illuminate\Http\UploadedFile;

uses()->group('asset-image-test');

uses(HydraMedia::class);

const ASSET_TEST_IMAGE = __DIR__.'/../../assets/test.jpg';

const ASSET_TEST_OUTPUT_DIR = __DIR__.'/../../assets/test/output';

const ASSET_TEST_STORAGE_DIR = 'asset_test';

function cleanAssetTestOutputDir(): void
{
    if (! is_dir(ASSET_TEST_OUTPUT_DIR)) {
        mkdir(ASSET_TEST_OUTPUT_DIR, 0775, true);
        touch(ASSET_TEST_OUTPUT_DIR.'/.gitkeep');

        return;
    }

    foreach (scandir(ASSET_TEST_OUTPUT_DIR) as $entry) {
        if (in_array($entry, ['.', '..', '.gitkeep'], true)) {
            continue;
        }

        $path = ASSET_TEST_OUTPUT_DIR.'/'.$entry;

        if (is_dir($path)) {
            rmdir($path);
        } else {
            unlink($path);
        }
    }
}

function cleanAssetTestStorageDir(): void
{
    $path = storage_path('app/public/'.ASSET_TEST_STORAGE_DIR);

    if (! is_dir($path)) {
        return;
    }

    foreach (scandir($path) as $entry) {
        if (in_array($entry, ['.', '..'], true)) {
            continue;
        }

        $file = $path.'/'.$entry;

        if (is_dir($file)) {
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

beforeEach(function () {
    cleanAssetTestOutputDir();
    cleanAssetTestStorageDir();
});

function assetTestImage(): UploadedFile
{
    expect(ASSET_TEST_IMAGE)->toBeReadableFile();

    return new UploadedFile(
        ASSET_TEST_IMAGE,
        'test.jpg',
        mime_content_type(ASSET_TEST_IMAGE) ?: 'image/jpeg',
        null,
        true
    );
}

function writeAssetOutput(string $storageFolder, string $storedFilename, string $outputFilename): string
{
    $source = storage_path('app/public/'.$storageFolder.'/'.$storedFilename);
    $destination = ASSET_TEST_OUTPUT_DIR.'/'.$outputFilename;

    expect($source)->toBeReadableFile();

    copy($source, $destination);

    return $destination;
}

it('processes assets/test.jpg and writes outputs to assets/test/output', function () {
    cleanAssetTestOutputDir();
    cleanAssetTestStorageDir();

    $originalSize = filesize(ASSET_TEST_IMAGE);
    [$originalWidth, $originalHeight] = getimagesize(ASSET_TEST_IMAGE);

    // Compressed, original format
    $compressed = $this->storeMedia(assetTestImage(), ASSET_TEST_STORAGE_DIR, true, new MediaOption);
    $compressedPath = writeAssetOutput(ASSET_TEST_STORAGE_DIR, $compressed, 'compressed_original.jpg');
    [$compressedWidth, $compressedHeight] = getimagesize($compressedPath);

    expect($compressedWidth)->toBe($originalWidth);
    expect($compressedHeight)->toBe($originalHeight);
    expect(filesize($compressedPath))->toBeGreaterThan(0);

    // WebP via config
    config(['hydrastorage.save_as_webp' => true]);
    $webpConfig = $this->storeMedia(assetTestImage(), ASSET_TEST_STORAGE_DIR, true, new MediaOption);
    $webpConfigPath = writeAssetOutput(ASSET_TEST_STORAGE_DIR, $webpConfig, 'webp_config.webp');

    expect($webpConfig)->toEndWith('.webp');
    expect(mime_content_type($webpConfigPath))->toBe('image/webp');
    expect(filesize($webpConfigPath))->toBeLessThan($originalSize);

    // WebP via media option
    config(['hydrastorage.save_as_webp' => false]);
    $webpOption = $this->storeMedia(
        assetTestImage(),
        ASSET_TEST_STORAGE_DIR,
        true,
        (new MediaOption)->webp()
    );
    $webpOptionPath = writeAssetOutput(ASSET_TEST_STORAGE_DIR, $webpOption, 'webp_option.webp');

    expect($webpOption)->toEndWith('.webp');
    expect(mime_content_type($webpOptionPath))->toBe('image/webp');

    // Quality compression to WebP
    $quality = $this->storeMedia(
        assetTestImage(),
        ASSET_TEST_STORAGE_DIR,
        true,
        (new MediaOption)->setQuality(60)
    );
    $qualityPath = writeAssetOutput(ASSET_TEST_STORAGE_DIR, $quality, 'quality_60.webp');

    expect($quality)->toEndWith('.webp');
    expect(mime_content_type($qualityPath))->toBe('image/webp');
    expect(filesize($qualityPath))->toBeLessThan($originalSize);

    // Resize to medium (600x600)
    $resized = $this->storeMedia(
        assetTestImage(),
        ASSET_TEST_STORAGE_DIR,
        true,
        (new MediaOption)->resize('medium')
    );
    $resizedPath = writeAssetOutput(ASSET_TEST_STORAGE_DIR, $resized, 'resize_medium.jpg');
    [$resizedWidth, $resizedHeight] = getimagesize($resizedPath);

    expect($resizedWidth)->toBe(600);
    expect($resizedHeight)->toBe(600);

    // Ensure all expected output files exist
    expect(ASSET_TEST_OUTPUT_DIR.'/compressed_original.jpg')->toBeFile();
    expect(ASSET_TEST_OUTPUT_DIR.'/webp_config.webp')->toBeFile();
    expect(ASSET_TEST_OUTPUT_DIR.'/webp_option.webp')->toBeFile();
    expect(ASSET_TEST_OUTPUT_DIR.'/quality_60.webp')->toBeFile();
    expect(ASSET_TEST_OUTPUT_DIR.'/resize_medium.jpg')->toBeFile();
});
