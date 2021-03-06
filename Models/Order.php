<?php

namespace App\Models;

use orpheusohms\phpmvc\Db\DbModel;

class Order extends DbModel
{
    public static function tableName(): string
    {
        return "orders";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'user_id',
            'products',
            'delivery_method',
            'delivery_fee',
            'total_charge',
            'total_items',
        ];
    }
}
