<?php

namespace App\Models;

use orpheusohms\phpmvc\Db\DbModel;

class Currency extends DbModel
{
    public static function tableName(): string
    {
        return "currencies";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'name',
            'symbol',
        ];
    }
}
