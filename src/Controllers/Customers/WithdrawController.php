<?php

namespace App\Controllers\Customers;;

use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Services\TransactionManager;
use Exception;

class WithdrawController
{
    
    /**
     * Get withdraw page view
     *
     * @param Request $request
     * @return mixed
     */
    public function withdrawPage(Request $request): mixed
    {
        return Response::view('customer/withdraw', ['page_title' => 'Withdaw Balance']);
    }

    /**
     * Handle withdraw request
     *
     * @param Request $request
     * @return mixed
     */
    public function handleWithdraw(Request $request): mixed
    {
        try {
            $this->validatedWithdrawRequestData($request->all());
            TransactionManager::withdraw($request->amount, $request->user);

            flash_message('success', 'Your withdraw has been completed!');
        } catch(Exception $e){
            flash_message('error', $e->getMessage());
        }

        return Response::redirect('/customer/withdraw');
    }

    /**
     * Validate the request data
     *
     * @param array $data
     * @return mixed
     */
    private function validatedWithdrawRequestData(array $data): mixed
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
