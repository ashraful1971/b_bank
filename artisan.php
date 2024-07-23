<?php

// auto loader
require_once 'vendor/autoload.php';

// required files
require_once 'src/Configs/app.php';
require_once 'src/Libs/functions.php';


use App\Commands\AddAdmin;
use App\Core\Console;

// register options
Console::addOption(AddAdmin::instance());

// run app
Console::run();

