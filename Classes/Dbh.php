<?php

class Dbh {
  private $dbusername = 'root'; // TODO: Move to dot env file
  private $dbpassword = ''; // TODO: Move to dot env file
  private $host = '127.0.0.1'; // TODO: Move to dot env file
  private $dbname = 'file_system'; // TODO: Move to dot env file

  public function __construct() {}

  protected function connect(){
    try{
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      $pdo = new PDO($dsn, $this->dbusername, $this->dbpassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e){
      die("Unable to connect to the database: " . $e->getMessage());
    }
  } 
}
