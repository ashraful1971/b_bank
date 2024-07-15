<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Models\User;
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
            $this->validateLoginCredentials($request->all());
            $this->attemptToLogin($request->all());

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
            $this->validateRegisterCredentials($request->all());
            $this->attemptToRegister($request->all());

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

    /**
     * Validate login credentials
     *
     * @param array $credentials
     * @return void
     */
    private function validateLoginCredentials(array $credentials): void
    {
        $validation = Validation::make($credentials, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }
    }

    /**
     * Validate register credentials
     *
     * @param array $credentials
     * @return void
     */
    private function validateRegisterCredentials(array $credentials): void
    {
        $validation = Validation::make($credentials, [
            'first_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }
    }

    /**
     * Try to login using the credentials
     *
     * @param array $credentials
     * @return void
     */
    private function attemptToLogin(array $credentials): void
    {
        $user = User::find('email', $credentials['email']);

        if (!$user || !password_verify($credentials['password'], $user?->password)) {
            throw new Exception('Invalid credentials!');
        }

        Auth::login($user);
    }

    /**
     * Try to register using the credentials
     *
     * @param array $credentials
     * @return void
     */
    private function attemptToRegister(array $credentials): void
    {
        $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT);

        // store data if not user already exist
        if (User::find('email', $credentials['email'])) {
            throw new Exception('An account already exist with this email.');
        } else {
            // store data
            User::create($credentials);
            flash_message('success', 'Your account was created successfully!');
        }
    }
}
