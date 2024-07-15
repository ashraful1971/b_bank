<?php

namespace App\Controllers;

use App\Core\Response;

class PageController
{
    /**
     * Get home page view
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return Response::view('home');
    }

    /**
     * Get 404 page view
     *
     * @return mixed
     */
    public function pageNotFound(): mixed
    {
        return Response::view('404');
    }
}
