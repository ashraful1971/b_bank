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
            
            if(config('database') == 'file'){
                return LocalStorage::init(DB_PATH);
            }

            return DBStorage::init(config('db_host'), config('db_name'), config('db_username'), config('db_password'));
        });
    }
}