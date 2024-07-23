<?php

use App\Controllers\Admin\CustomerController;
use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Admin\TransactionController;
use App\Controllers\AuthController;
use App\Controllers\Customers\DashboardController;
use App\Controllers\Customers\DepositController;
use App\Controllers\Customers\TransferController;
use App\Controllers\Customers\WithdrawController;
use App\Controllers\PageController;
use App\Core\Route;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\Authentication;
use App\Middlewares\CustomerMiddleware;
use App\Middlewares\Guest;

Route::get('/', [PageController::class, 'index']);
Route::get('/404', [PageController::class, 'pageNotFound']);

Route::get('/customer/dashboard', [DashboardController::class, 'dashboardPage'], [CustomerMiddleware::class]);
Route::get('/customer/deposit', [DepositController::class, 'depositPage'], [CustomerMiddleware::class]);
Route::post('/customer/deposit', [DepositController::class, 'handleDeposit'], [CustomerMiddleware::class]);
Route::get('/customer/withdraw', [WithdrawController::class, 'withdrawPage'], [CustomerMiddleware::class]);
Route::post('/customer/withdraw', [WithdrawController::class, 'handleWithdraw'], [CustomerMiddleware::class]);
Route::get('/customer/transfer', [TransferController::class, 'transferPage'], [CustomerMiddleware::class]);
Route::post('/customer/transfer', [TransferController::class, 'handleTransfer'], [CustomerMiddleware::class]);

Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboardPage'], [AdminMiddleware::class]);
Route::get('/admin/customers', [CustomerController::class, 'customersPage'], [AdminMiddleware::class]);
Route::get('/admin/customers/add', [CustomerController::class, 'addCustomerPage'], [AdminMiddleware::class]);
Route::post('/admin/customers', [CustomerController::class, 'handleCreateCustomer'], [AdminMiddleware::class]);
Route::get('/admin/customers/transactions', [TransactionController::class, 'customerTransactionsPage'], [AdminMiddleware::class]);
Route::get('/admin/transactions', [TransactionController::class, 'transactionsPage'], [AdminMiddleware::class]);

Route::get('/login', [AuthController::class, 'loginPage'], [Guest::class]);
Route::post('/login', [AuthController::class, 'handleLogin'], [Guest::class]);
Route::get('/register', [AuthController::class, 'registerPage'], [Guest::class]);
Route::post('/register', [AuthController::class, 'handleRegister'], [Guest::class]);
Route::get('/logout', [AuthController::class, 'handleLogout', [Authentication::class]]);