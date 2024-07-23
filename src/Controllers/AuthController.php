<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use Exception;

class AuthController
{

    /**
     * Get login page view
     *
     * @return mixed
     */
    public function loginPage(): mixed
    {
        return Response::view('login');
    }

    /**
     * Login the user
     *
     * @param Request $request
     * @return mixed
     */
    public function handleLogin(Request $request): mixed
    {
        try {
           AuthService::login($request->all());

            return Response::redirect('/customer/dashboard');

        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
            return Response::redirect('/login');
        }
    }

    /**
     * Get register page view
     *
     * @return mixed
     */
    public function registerPage(): mixed
    {
        return Response::view('register');
    }

    /**
     * Register new user
     *
     * @param Request $request
     * @return mixed
     */
    public function handleRegister(Request $request): mixed
    {
        try {
            $request->is_admin = false;
            
            AuthService::register($request->all());

            flash_message('success', 'Your account was created successfully!');

            return Response::redirect('/login');

        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
            return Response::redirect('/register');
        }
    }

    /**
     * Logout logged in user
     *
     * @param Request $request
     * @return void
     */
    public function handleLogout(): void
    {
        Auth::logout();
    }
}
