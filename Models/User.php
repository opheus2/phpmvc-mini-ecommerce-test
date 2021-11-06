<?php

namespace App\Models;

use orpheusohms\phpmvc\Db\DbModel;

class User extends DbModel
{
    public static function tableName(): string
    {
        return "users";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'first_name',
            'last_name',
            'email',
            'password',
            'account_balance',
            'status'
        ];
    }
}
