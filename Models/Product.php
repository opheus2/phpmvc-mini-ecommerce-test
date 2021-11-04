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
}
