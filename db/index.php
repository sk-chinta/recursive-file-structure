<?php

class Dbh {
  public function __construct() {}

  protected function connect(){
    $dbusername = getenv('DB_USER');
    $dbpassword = getenv('DB_PASS');
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');

    try{
      $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
      $pdo = new PDO($dsn, $dbusername, $dbpassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e){
      die("Unable to connect to the database: " . $e->getMessage());
    }
  } 
}
