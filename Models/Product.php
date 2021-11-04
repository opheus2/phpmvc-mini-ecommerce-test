<?php

namespace App\Models;

use App\Core\Db\DbModel;

class Product extends DbModel
{
    public static function tableName(): string
    {
        return "products";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'name',
            'description',
            'amount',
            'price',
            'currency_id',
            'average_rating',
            'image',
            'weight',
            'rating_count',
            'status',
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
