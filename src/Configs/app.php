<?php

use App\Providers\AppServiceProvider;

return [
    'database' => 'mysql', // set either file or mysql

    'providers' => [
        AppServiceProvider::class
    ], // all the providers will be listed here

    'db_host' => 'localhost',
    'db_name' => 'b_bank',
    'db_username' => 'root',
    'db_password' => '',
];