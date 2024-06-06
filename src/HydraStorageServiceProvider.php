<?php

namespace HydraStorage\HydraStorage;

use HydraStorage\HydraStorage\Commands\HydraStorageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HydraStorageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */

        if (! extension_loaded('imagick')) {
            throw new \Exception('Imagick extension is not loaded');
        }

        $package
            ->name('hydrastorage')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_hydrastorage_table')
            ->hasCommand(HydraStorageCommand::class);

        // want to set default media option
        $this->app->singleton('mediaOption', function ($app) {
            return new \HydraStorage\HydraStorage\Service\Option\MediaOption('medium', 100, 100, 100);
        });

    }
}
