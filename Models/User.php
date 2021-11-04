<?php

namespace App\Models;

use App\Core\Db\DbModel;

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

    public function ruleMessages(): array
    {
        return [
            'confirm_password' => [
                self::RULE_MATCH => 'This field must be the same as Password'
            ]
        ];
    }

    public function newUser(array $data)
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save($data);
    }
}
