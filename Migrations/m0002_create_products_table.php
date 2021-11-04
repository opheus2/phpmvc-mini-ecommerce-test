<?php 

use App\Core\Application;


class m0002_create_products_table
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (
           id INT AUTO_INCREMENT PRIMARY KEY,
           name VARCHAR(255) NOT NULL,
           description LONGTEXT NOT NULL,
           last_name VARCHAR(255) NOT NULL,
           password VARCHAR(512) NOT NULL,
           account_balance DOUBLE DEFAULT 500,
           status TINYINT DEFAULT 1,
           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
       ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }


    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}
