<?php

class Database
{

    private static $_instance = null;
    public $conn;
    
    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=".DB_HOST.";port=3306;dbname=".DB_NAME.";charset=utf8", DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function connectDB()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}
