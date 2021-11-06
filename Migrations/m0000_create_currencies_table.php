<?php

use orpheusohms\phpmvc\Application;

class m0000_create_currencies_table
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE currencies ( 
            id INT(11) AUTO_INCREMENT , 
            name VARCHAR(255) NOT NULL, 
            symbol VARCHAR(50) NOT NULL, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (id)) ENGINE = InnoDB";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE currencies;";
        $db->pdo->exec($SQL);
    }
}
