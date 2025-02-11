<?php

namespace Pteroca\PterodactylAddon;

use Illuminate\Support\ServiceProvider;
use Pteroca\PterodactylAddon\Commands\GenerateSecretKey;
use Spatie\LaravelPackageTools\Package;

class PterodactylApiAddonServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            GenerateSecretKey::class,
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
