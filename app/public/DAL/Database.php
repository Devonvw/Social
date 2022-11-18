<?php
class DB {
   const SERVER_NAME = "mysql";
   const USERNAME = "root";
   const PASSWORD = "secret123";
   const DATABASE_NAME = "social";

  // Properties
  public static $connection;
  
  function __construct() {
    if (is_null($this->connection)) {
        try {
            $connection = new PDO("mysql:host=$this->SERVER_NAME;dbname=$this->DATABASE_NAME",$this->USERNAME, $this->PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        }
    }
  }
}
?>