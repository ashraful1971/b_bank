<?php

namespace App\Controllers\Customers;;

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
        $transactions = Transaction::findAll([
            ['user_id', '==', $request->user->id],
            ['receiver_id', '==', $request->user->id],
        ], Operation::OR);

        return Response::view('customer/dashboard', [
            'page_title' => "Howdy, ".authUser()->fullname." 👋",
            'transactions' => array_reverse($transactions),
        ]);
    }
    
}
