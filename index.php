<?php

// auto loader

use App\Providers\AppServiceProvider;

require_once 'vendor/autoload.php';

// required files
require_once 'src/Configs/app.php';
require_once 'src/Libs/functions.php';
require_once 'src/Routes/web.php';

// service container
$container = container();

// run app
App\Core\Application::init($container)
    ->withRoutes(App\Core\Route::collection())
    ->withProviders([
        AppServiceProvider::class
    ])
    ->run(App\Core\Request::create());

