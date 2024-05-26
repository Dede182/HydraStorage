<?php

namespace HydraStorage\HydraStorage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use HydraStorage\HydraStorage\Commands\HydraStorageCommand;

class HydraStorageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('hydrastorage')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_hydrastorage_table')
            ->hasCommand(HydraStorageCommand::class);
    }
}
