<?php

namespace HydraStorage\HydraStorage\Providers;

use HydraStorage\HydraStorage\Contracts\HydraMediaInterface;
use HydraStorage\HydraStorage\Service\HydraStore;
use Illuminate\Support\ServiceProvider;

class StorageInterfaceProvider implements ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HydraMediaInterface::class, HydraStore::class);
    }

    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            HydraMediaInterface::class,
        ];
    }
}
