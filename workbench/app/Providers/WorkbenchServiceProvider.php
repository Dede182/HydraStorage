<?php

namespace Workbench\App\Providers;

use HydraStorage\HydraStorage\Service\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::post('/submit', function (Request $request) {
            return (new TestController())->store($request);
        });

    }
}
