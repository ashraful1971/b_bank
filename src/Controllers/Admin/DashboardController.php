<?php

namespace App\Controllers\Admin;;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Models\Transaction;

class DashboardController
{
    
    /**
     * Get dashboard page view
     *
     * @param Request $request
     * @return mixed
     */
    public function dashboardPage(Request $request): mixed
    {
        return Response::redirect('/admin/customers');
    }
    
}
