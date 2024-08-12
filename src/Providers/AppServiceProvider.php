<?php

namespace App\Providers;

use App\Core\Contracts\DataStorage;
use App\Core\Contracts\ServiceContainer;
use App\Core\Contracts\ServiceProvider;
use App\Core\DBStorage;
use App\Core\LocalStorage;

class AppServiceProvider implements ServiceProvider {
    public function register(ServiceContainer $container): void
    {
        $container->singleton(DataStorage::class, function(){
            
            if(config('app', 'database') == 'file'){
                return LocalStorage::init(DB_PATH);
            }

            return DBStorage::init(config('app', 'db_host'), config('app', 'db_name'), config('app', 'db_username'), config('app', 'db_password'));
        });
    }
}