<?php

use App\Controllers\AuthController;
use App\Controllers\Customers\DashboardController;
use App\Controllers\Customers\DepositController;
use App\Controllers\Customers\TransferController;
use App\Controllers\Customers\WithdrawController;
use App\Controllers\PageController;
use App\Core\Route;
use App\Middlewares\Authentication;
use App\Middlewares\Guest;

Route::get('/', [PageController::class, 'index']);
Route::get('/404', [PageController::class, 'pageNotFound']);

Route::get('/customer/dashboard', [DashboardController::class, 'dashboardPage'], [Authentication::class]);
Route::get('/customer/deposit', [DepositController::class, 'depositPage'], [Authentication::class]);
Route::post('/customer/deposit', [DepositController::class, 'handleDeposit'], [Authentication::class]);
Route::get('/customer/withdraw', [WithdrawController::class, 'withdrawPage'], [Authentication::class]);
Route::post('/customer/withdraw', [WithdrawController::class, 'handleWithdraw'], [Authentication::class]);
Route::get('/customer/transfer', [TransferController::class, 'transferPage'], [Authentication::class]);
Route::post('/customer/transfer', [TransferController::class, 'handleTransfer'], [Authentication::class]);

Route::get('/login', [AuthController::class, 'loginPage'], [Guest::class]);
Route::post('/login', [AuthController::class, 'handleLogin'], [Guest::class]);
Route::get('/register', [AuthController::class, 'registerPage'], [Guest::class]);
Route::post('/register', [AuthController::class, 'handleRegister'], [Guest::class]);
Route::get('/logout', [AuthController::class, 'handleLogout', [Authentication::class]]);