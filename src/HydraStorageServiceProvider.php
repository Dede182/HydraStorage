<?php

namespace HydraStorage\HydraStorage;

use HydraStorage\HydraStorage\Commands\HydraStorageCommand;
use HydraStorage\HydraStorage\Contracts\HydraMediaInterface;
use HydraStorage\HydraStorage\Service\HydraStore;
use HydraStorage\HydraStorage\Service\ImageDriverFactory;
use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Intervention\Image\ImageManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HydraStorageServiceProvider extends PackageServiceProvider
{
    public $bindings = [
        'HydraStorage\HydraStorage\Contracts\HydraMediaInterface' => 'HydraStorage\HydraStorage\Service\HydraStore',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('hydrastorage')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_hydrastorage_table')
            ->hasCommand(HydraStorageCommand::class);
    }

    public function boot(): void
    {
        parent::boot();
    }

    public function register(): void
    {
        parent::register();

        $this->app->bind(HydraMediaInterface::class, HydraStore::class);

        $this->app->singleton('mediaOption', function () {
            return MediaOption::create();
        });

        $this->app->singleton(MediaOption::class, function () {
            return MediaOption::create();
        });

        $this->app->singleton('ImageManager', function () {
            return new ImageManager(ImageDriverFactory::make());
        });
    }
}
