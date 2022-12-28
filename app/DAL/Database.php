<?php
class DB {
  const SERVER_NAME = "mysql";
  const USERNAME = "root";
  const PASSWORD = "secret123";
  const DATABASE_NAME = "social";
  // Properties
  public static $connection;
  
  function __construct() {
    if (is_null(self::$connection)) {
        try {
            self::$connection = new PDO("mysql:host=".self::SERVER_NAME.";dbname=".self::DATABASE_NAME, self::USERNAME, self::PASSWORD);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        }
    }
  }
}
?>