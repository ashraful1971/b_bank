# Simple e-Banking App

**A PHP MVC application for basic banking functionalities.**

## Overview
This project is a simple e-banking application built using PHP and following the Model-View-Controller (MVC) architectural pattern.

**Admin Features:**
* View all transactions made by all users.
* Search and view transactions by a specific user using their email.
* View a list of all registered customers.

**Customer Features:**
* Customers can register using their name, email, and password.
* Customers can log in using their registered email and password.
* See a list of all of their transactions.
* Deposit money to their account.
* Withdraw money from their account.
* Transfer money to another customer's account by specifying their email address.
* See the current balance of their account.

## Prerequisites
* PHP
* Composer

## Installation (File)
1. Clone the repository
2. Run **composer install**
4. Go to **Configs/app.php** and set **database='file'**
5. Run **php ./artisan.php**
6. Select the option to create admin user
6. Enter the credentials for the new admin account
7. All done!

## Installation (MYSQL)
1. Clone the repository
2. Run **composer install**
4. Go to **Configs/app.php** and set **database='mysql'** and provide database info
5. Run **php ./artisan.php**
6. Select the migration option to perform migration
7. Select the option to create admin user
8. Enter the credentials for the new admin account
9. All done!