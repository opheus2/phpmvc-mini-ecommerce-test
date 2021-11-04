<?php

namespace App\Core\Db;

use App\core\Model;
use App\Core\Application;
use Exception;
use PDO;

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
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql LIMIT 1");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    public static function findAll(array $where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function groupBy(array $group, array $where = [])
    {
        # code...
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
