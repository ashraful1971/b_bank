<?php

// auto loader
require_once 'vendor/autoload.php';

// required files
require_once 'src/Constants/app.php';
require_once 'src/Libs/functions.php';


use App\Commands\AddAdmin;
use App\Commands\RunMigration;
use App\Core\Console;

$providers = config('app', 'providers');

// register options
Console::addOption(AddAdmin::instance());
Console::addOption(RunMigration::instance());

// run app
Console::run($providers);

