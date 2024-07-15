<?php

namespace App\Controllers\Customers;;

use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Models\User;
use App\Services\TransactionManager;
use Exception;

class TransferController
{
    
    /**
     * Get transfer page view
     *
     * @param Request $request
     * @return mixed
     */
    public function transferPage(Request $request): mixed
    {
        return Response::view('customer/transfer', ['page_title' => 'Transfer Balance']);
    }

    /**
     * Handle transfer request
     *
     * @param Request $request
     * @return mixed
     */
    public function handleTransfer(Request $request): mixed
    {
        try {
            $this->validatedTransferRequestData($request->all());

            $receiver = User::find('email', $request->email);

            if(!$receiver){
                throw new Exception('Enter valid user email.');
            }

            TransactionManager::transfer($request->amount, $request->user, $receiver);

            flash_message('success', 'Your transfer has been completed!');
        } catch(Exception $e){
            flash_message('error', $e->getMessage());
        }

        return Response::redirect('/customer/transfer');
    }

    /**
     * Validate the request data
     *
     * @param array $data
     * @return mixed
     */
    private function validatedTransferRequestData(array $data): mixed
    {
        $validation = Validation::make($data, [
            'email' => ['required', 'email'],
            'amount' => ['required'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }

        return $validation->validatedData();
    }
    
}
