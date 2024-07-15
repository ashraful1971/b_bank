<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Exception;

class TransactionManager {
    const DEPOSIT = 'deposit';
    const WITHDRAW = 'withdraw';
    const TRANSFER = 'transfer';

    public static function deposit($amount, User $user): void
    {
        if(!$amount){
            throw new Exception('Enter a valid amount');
        }

        Transaction::create([
            'user_id' => $user->id,
            'receiver_id' => '',
            'type' => self::DEPOSIT,
            'amount' => $amount,
        ]);

        $user->balance = $user->balance + $amount;
        $user->save();
    }
    
    public static function withdraw($amount, User $user): void
    {
        if(!$amount){
            throw new Exception('Enter a valid amount');
        }
        
        if($amount > $user->balance){
            throw new Exception('You don\'t have enough balance.');
        }

        Transaction::create([
            'user_id' => $user->id,
            'receiver_id' => '',
            'type' => self::WITHDRAW,
            'amount' => $amount,
        ]);

        $user->balance = $user->balance - $amount;
        $user->save();
    }
    
    public static function transfer($amount, User $user, User $receiver): void
    {
        if(!$amount){
            throw new Exception('Enter a valid amount');
        }
        
        if($amount > $user->balance){
            throw new Exception('You don\'t have enough balance.');
        }

        Transaction::create([
            'user_id' => $user->id,
            'receiver_id' => $receiver->id,
            'type' => self::TRANSFER,
            'amount' => $amount,
        ]);

        $user->balance = $user->balance - $amount;
        $user->save();
        
        $receiver->balance = $receiver->balance + $amount;
        $receiver->save();
    }
}