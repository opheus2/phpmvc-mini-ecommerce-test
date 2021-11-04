<?php

namespace App\Core\Db;

use App\core\Model;
use App\Core\Application;
use Exception;

abstract class DbModel
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save(array $data)
    {
        $this->validateAttribute(array_keys($data));
        $tableName = $this->tableName();
        $attributes = array_keys($data);

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $this->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES(" . implode(',', $params) . ");");

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        
        $statement->execute();

        return true;
    }

    public static function findOne(array $where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        // $values = array_values($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    public function validateAttribute(array $data)
    {
        $notMatchedAttributes = array_diff($data, $this->attributes());
        if (!empty($notMatchedAttributes)) {
            $fields = (string) implode(',', $notMatchedAttributes);
            throw new Exception("The following attributes {$fields} are not available.", 400);
        }
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
