<?php

namespace App\Controllers\Admin;;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Models\User;
use App\Services\AuthService;
use App\Services\TransactionManager;
use Exception;

class CustomerController
{
    
    /**
     * Get deposit page view
     *
     * @param Request $request
     * @return mixed
     */
    public function customersPage(Request $request): mixed
    {
        $customers = User::findAll([
           [ 'is_admin', '==', false]
        ], Operation::AND);
        return Response::view('admin/customers', [
            'page_title' => 'Customers',
            'customers' => array_reverse($customers),
        ]);
    }
    
    /**
     * Get deposit page view
     *
     * @param Request $request
     * @return mixed
     */
    public function addCustomerPage(Request $request): mixed
    {
        return Response::view('admin/add_customer', [
            'page_title' => 'Add Customer',
        ]);
    }
    
    /**
     * Handle create customer request
     *
     * @param Request $request
     * @return mixed
     */
    public function handleCreateCustomer(Request $request): mixed
    {
        try {
            AuthService::register($request->all());

            flash_message('success', 'New user account was created successfully!');

            return Response::redirect('/admin/customers');

        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
            return Response::redirect('/admin/customers/add');
        }
    }
    
}
