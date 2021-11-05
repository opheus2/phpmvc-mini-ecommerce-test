<?php

namespace App\Core\Db;

use PDO;
use App\Core\Application;

class Database
{
    public PDO $pdo;
    /**
     * Class constructor.
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/Migrations');

        $notAppliedMigrations = array_diff($files, $appliedMigrations);

        $newMigrations = [];

        foreach ($notAppliedMigrations as $migration) 
        {
            if ($migration === '.' || $migration === '..') 
            {
                continue;
            }

            $classFile = Application::$ROOT_DIR . "/Migrations/{$migration}";
            require_once $classFile;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;
            $this->log("Applying migration {$migration}");
            $instance->up();
            $this->log("Applied migration {$migration} successfully");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) 
        {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("Nothing to migrate");
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration from migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $inserts = implode(",", array_map(fn ($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $inserts");
        $statement->execute();
    }

    public function insert(array $data, string $tableName)
    {
        $attributes = array_keys($data);

        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = $this->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES(" . implode(',', $params) . ");");

        foreach ($data as $key => $value) 
        {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return true;
    }

    public function log($message)
    {
        $date = date('Y-m-d H:i:s');
        echo "[{$date}] {$message}" . PHP_EOL;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
