<?php

namespace App\Controllers\Customers;;

use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Services\TransactionManager;
use Exception;

class DepositController
{
    
    /**
     * Get deposit page view
     *
     * @param Request $request
     * @return mixed
     */
    public function depositPage(Request $request): mixed
    {
        return Response::view('customer/deposit', ['page_title' => 'Deposit Balance']);
    }
    
    /**
     * Handle deposit request
     *
     * @param Request $request
     * @return mixed
     */
    public function handleDeposit(Request $request): mixed
    {
        try {
            $this->validatedDepositRequestData($request->all());
            TransactionManager::deposit($request->amount, $request->user);

            flash_message('success', 'Your deposit has been completed!');
        } catch(Exception $e){
            flash_message('error', $e->getMessage());
        }

        return Response::redirect('/customer/deposit');
    }

    /**
     * Validate the request data
     *
     * @param array $data
     * @return mixed
     */
    private function validatedDepositRequestData(array $data): mixed
    {
        $validation = Validation::make($data, [
            'amount' => ['required'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }

        return $validation->validatedData();
    }
    
}
