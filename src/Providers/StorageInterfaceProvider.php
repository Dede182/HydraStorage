<?php

namespace HydraStorage\HydraStorage\Providers;

use HydraStorage\HydraStorage\Contracts\HydraMediaInteface;
use HydraStorage\HydraStorage\Service\HydraStore;
use Illuminate\Support\ServiceProvider;

class StorageInterfaceProvider implements ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HydraMediaInteface::class, HydraStore::class);
    }

    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            HydraMediaInteface::class,
        ];
    }
}
