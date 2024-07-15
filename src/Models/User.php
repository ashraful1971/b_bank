<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table_name = 'users';
    protected $columns = ['first_name', 'last_name', 'email', 'password', 'is_admin', 'balance'];
    protected $default = [
        'is_admin' => false,
        'balance' => 0
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
