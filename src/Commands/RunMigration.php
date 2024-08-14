<?php

namespace App\Commands;

use App\Core\Contracts\Command;
use Exception;
use PDO;

class RunMigration implements Command
{
    private static $instance;
    private static $option_name = "Run migration";

    public static function instance(): static
    {
        if (!self::$instance) {
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
        if(config('database') != 'mysql'){
            echo PHP_EOL . 'Error: Set the database value from Configs/app.php to mysql to run migration'. PHP_EOL;
            exit;
        }

        $dbname = config('db_name');
        try {
            $this->createDatabase($dbname);
            $this->createUsersTable($dbname);
            $this->createTransactionsTable($dbname);

            echo PHP_EOL . 'Migration has been completed!' . PHP_EOL;
        } catch (Exception $e) {
            echo PHP_EOL . 'Error: ' . $e->getMessage() . PHP_EOL;
        }
    }

    private function createDatabase($dbname)
    {
        $db = new PDO("mysql:host=".config('db_host'), config('db_username'), config('db_password'));
        $sql = "CREATE DATABASE $dbname";
        $db->exec($sql);
    }

    private function createUsersTable($dbname)
    {
        $db = new PDO("mysql:host=".config('db_host').";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "CREATE TABLE users (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `first_name` VARCHAR(255) NOT NULL,
            `last_name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `is_admin` BOOLEAN NOT NULL DEFAULT 0,
            `balance` FLOAT NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }
    
    private function createTransactionsTable($dbname)
    {
        $db = new PDO("mysql:host=".config('db_host').";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "CREATE TABLE transactions (
            `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `receiver_id` INT UNSIGNED,
            `type` ENUM('deposit', 'withdraw', 'transfer') NOT NULL,
            `amount` DECIMAL(10,2) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }
}
