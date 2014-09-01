<?php

class DatabaseMongo {

    private static $instance;

    private function __construct() {        
    }
    
    private function __clone() {        
    }
    
    public static function init() {
        if (isset(self::$instance))
            return self::$instance;            
  
        try {
            $connection = new MongoClient();
            self::$instance = $connection->selectDB(Config::mongo_db_name);
        } catch(MongoConnectionException $e) {
            die("Failed to connect to mongo database ".$e->getMessage());
        }
        
        return self::$instance;
    }
}
