<?php

namespace App\Controllers\Admin;;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Models\Transaction;
use App\Models\User;
class TransactionController
{
    
    /**
     * Get transaction page view
     *
     * @param Request $request
     * @return mixed
     */
    public function transactionsPage(Request $request): mixed
    {
        $transactions = Transaction::all();
        return Response::view('admin/transactions', [
            'page_title' => 'Transactions',
            'transactions' => array_reverse($transactions),
        ]);
    }
    
    /**
     * Get transaction page view
     *
     * @param Request $request
     * @return mixed
     */
    public function customerTransactionsPage(Request $request): mixed
    {
        $user = User::find('id', $request->user_id);

        $transactions = Transaction::findAll([
            ['user_id', '==', $request->user_id],
            ['receiver_id', '==', $request->user_id],
        ], Operation::OR);

        return Response::view('admin/customer_transactions', [
            'page_title' => 'Transactions of '.$user->fullname,
            'transactions' => array_reverse($transactions),
        ]);
    }
    
}
