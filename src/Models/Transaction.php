<?php

namespace App\Models;

use App\Core\Model;

class Transaction extends Model {
    protected $table_name = 'transactions';
    protected $columns = ['user_id', 'receiver_id', 'type', 'amount'];

    public function getReceiverAttribute(): ?User
    {
        $user_id = $this->user_id;

        if($this->receiver_id){
            $user_id = $this->receiver_id;
        }

        $receiver = User::find('id', $user_id);
        return $receiver;
    }
}