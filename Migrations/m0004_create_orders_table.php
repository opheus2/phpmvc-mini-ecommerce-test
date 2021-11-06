<?php

use orpheusohms\phpmvc\Application;

class m0004_create_orders_table
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE orders ( 
            id INT NOT NULL AUTO_INCREMENT , 
            user_id INT(11) NOT NULL , 
            products JSON NOT NULL , 
            delivery_method VARCHAR(50) NOT NULL , 
            delivery_fee DOUBLE NOT NULL , 
            total_charge DOUBLE NOT NULL , 
            total_items INT NOT NULL , 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , 
        PRIMARY KEY (id)) ENGINE = InnoDB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE orders;";
        $db->pdo->exec($SQL);
    }
}
