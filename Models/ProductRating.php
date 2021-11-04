<?php

namespace App\Models;

use App\Core\Db\DbModel;

class ProductRating extends DbModel
{
    public static function tableName(): string
    {
        return "product_ratings";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'user_id',
            'product_id',
            'rating'
        ];
    }
}