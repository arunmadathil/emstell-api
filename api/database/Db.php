<?php

namespace Database;

use PDOException;
use PDO;
use Config\Database;

class Db
{
    public function connect_db()
    {
        try {
            $DB_con = new PDO("mysql:host=" . Database::$DB_host . ";dbname=" . Database::$DB_name , Database::$DB_user, Database::$DB_pass);
            $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DB_con;
        } catch (PDOException $e) {
            echo  $e->getMessage(); exit;
        }
    }
}
