<?php

namespace App\Providers;

use App\Core\Contracts\DataStorage;
use App\Core\Contracts\ServiceContainer;
use App\Core\Contracts\ServiceProvider;
use App\Core\LocalStorage;

class AppServiceProvider implements ServiceProvider {
    public function register(ServiceContainer $container): void
    {
        $container->singleton(DataStorage::class, function(){
            return LocalStorage::init(DB_PATH);
        });
    }
}