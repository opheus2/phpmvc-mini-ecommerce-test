<?php

use orpheusohms\phpmvc\Application;

class m0002_create_products_table
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE products ( 
            id INT(11) AUTO_INCREMENT , 
            name VARCHAR(255) NOT NULL ,
            category VARCHAR(255) NOT NULL ,
            description LONGTEXT NULL , 
            amount DOUBLE NOT NULL , 
            weight VARCHAR(10) NULL , 
            image VARCHAR(512) NULL,
            rating_count DOUBLE DEFAULT 0, 
            average_rating DOUBLE DEFAULT 0 , 
            currency_id INT(11) NOT NULL , 
            status VARCHAR(50) DEFAULT 'active' , 
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (id)) ENGINE = InnoDB";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE products;";
        $db->pdo->exec($SQL);
    }
}
