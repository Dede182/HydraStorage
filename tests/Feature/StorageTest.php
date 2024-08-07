<?php

use HydraStorage\HydraStorage\Expections\InvalidInputMediaFormat;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use HydraStorage\HydraStorage\Traits\HydraMedia;
use Illuminate\Http\UploadedFile;

uses()->group('storage-test');

uses(HydraMedia::class);

it('can save with original format with single file', function () {
    $fakeFile = UploadedFile::fake()->image('test.jpg');

    $option = (new MediaOption);

    $media = $this->storeMedia($fakeFile, 'sub_storage_1', true, $option);

    $path = storage_path('app/public/sub_storage_1/'.$media);

    $image = getimagesize($path);

    $this->assertEquals(10, $image[0]);
    $this->assertEquals(10, $image[1]);

    $this->assertFileExists($path);
});

test('can save multi file with original format', function () {
    $fakeFiles = [
        UploadedFile::fake()->image('test1.jpg'),
        UploadedFile::fake()->image('test2.jpg'),
        UploadedFile::fake()->image('test3.jpg'),
    ];

    $option = (new MediaOption);

    $media = $this->storeMedia($fakeFiles, 'sub_storage_2', true, $option);

    $path = storage_path('app/public/sub_storage_2/'.$media[0]);

    $image = getimagesize($path);

    $this->assertEquals(10, $image[0]);
    $this->assertEquals(10, $image[1]);

    $this->assertFileExists($path);
});

test('can save with custom format with single file', function () {
    $fakeFile = UploadedFile::fake()->image('test.jpg');

    $options = (new MediaOption('import', 20, 400, 400, 'png'));
    $mediaOptions = $options->get();

    $media = $this->storeMedia($fakeFile, 'sub_storage_3', true, $options);

    $path = storage_path('app/public/sub_storage_3/'.$media);

    $image = getimagesize($path);

    $this->assertEquals($mediaOptions->width, $image[0]);
    $this->assertEquals($mediaOptions->height, $image[1]);

    $this->assertFileExists($path);
});

test('InvalidInputMediaFormat exception format return', function () {

    $fakeFile = UploadedFile::fake()->create('test.pdf', 100);

    $options = (new MediaOption('import', 20, 400, 400, 'pdf'));

    $this->expectException(InvalidInputMediaFormat::class);
    $media = $this->storeMedia($fakeFile, 'sub_storage_4', true, $options);

});

test('stored file size is less than original by reducing quality', function () {
    $fakeFile = UploadedFile::fake()->image('test.jpg')->size(6000000);

    $options = (new MediaOption('import', 80, 400, 400, 'jpg'));

    $media = $this->storeMedia($fakeFile, 'sub_storage_5', true, $options);

    $path = storage_path('app/public/sub_storage_5/'.$media);

    $originalSize = filesize($fakeFile);
    $storedSize = filesize($path);

    $this->assertLessThan($storedSize, $originalSize);

    $this->assertFileExists($path);
});
