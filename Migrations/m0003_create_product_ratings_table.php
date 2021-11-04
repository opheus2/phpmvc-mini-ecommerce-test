<?php

use App\Core\Application;

class m0003_create_product_ratings_table
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE product_ratings ( 
            id INT(11) AUTO_INCREMENT , 
            user_id INT(11) NOT NULL , 
            product_id INT(11) NOT NULL , 
            rating INT(11) NOT NULL DEFAULT active, 
            comment VARCHAR(255) NULL, 
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (id)) ENGINE = InnoDB";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE product_ratings;";
        $db->pdo->exec($SQL);
    }
}
