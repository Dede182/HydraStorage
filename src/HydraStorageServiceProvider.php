<?php

namespace HydraStorage\HydraStorage;

use HydraStorage\HydraStorage\Commands\HydraStorageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HydraStorageServiceProvider extends PackageServiceProvider
{

    public $bindings = [
        'HydraStorage\HydraStorage\Contracts\HydraMediaInteface' => 'HydraStorage\HydraStorage\Service\HydraStore',
    ];

    public function configurePackage(Package $package): void
    {
        $package
        ->name('hydrastorage')
        ->hasConfigFile()
        ->hasViews()
        ->hasMigration('create_hydrastorage_table')
        ->hasCommand(HydraStorageCommand::class);

        if (! extension_loaded('imagick')) {
            throw new \Exception('Imagick extension is not loaded');
        }

        $this->app->singleton('mediaOption', function ($app) {
            return (new \HydraStorage\HydraStorage\Service\Option\MediaOption(null,null,null,null))->setOriginal();
        });


    }
}
