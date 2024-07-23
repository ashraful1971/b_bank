<?php

namespace App\Models;

use App\Core\Model;

class Transaction extends Model {
    protected $table_name = 'transactions';
    protected $columns = ['user_id', 'receiver_id', 'type', 'amount'];

    public function getUserAttribute(): ?User
    {
        return User::find('id', $this->user_id);
    }

    public function getReceiverAttribute(): ?User
    {
        if(!$this->receiver_id){
            return $this->user;
        }

        return User::find('id', $this->receiver_id);
    }
}