<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\FilamentServiceProvider as FilamentProvider;
use Filament\Facades\Filament;

class FilamentServiceProvider extends FilamentProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();

        // ...

        // Register the Admin resource path

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
