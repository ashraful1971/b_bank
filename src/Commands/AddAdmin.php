<?php

namespace App\Commands;

use App\Core\Contracts\Command;
use App\Services\AuthService;
use Exception;

class AddAdmin implements Command {
    private static $instance;
    private static $option_name = "Add new admin";

    public static function instance(): static
    {
        if(!self::$instance){
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    public function getOptionName(): string
    {
        return self::$option_name;
    }

    public function handle(): void
    {

        $credentials = [];

        $credentials['first_name'] = readline('Enter First Name: ');
        $credentials['last_name'] = readline('Enter Last Name: ');
        $credentials['email'] = readline('Enter Email: ');
        $credentials['password'] = readline('Enter password: ');
        $credentials['is_admin'] = true;

        try {
            AuthService::register($credentials);
            echo PHP_EOL . 'New admin account created!' . PHP_EOL;
        } catch(Exception $e){
            echo PHP_EOL . 'Error: '.$e->getMessage(). PHP_EOL;
        }
    }
}