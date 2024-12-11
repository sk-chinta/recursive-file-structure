<?php
require_once 'Utility.php';

class FileSystem extends Dbh {
  private $outputFile = 'file_structure_output.txt';
  private $currentDir;
  private $utility;

  public function __construct($currentDir){
    $this->currentDir = $currentDir;
    $this->utility = new Utility();
  }


  public function findRecord($name){
    $stmt = parent::connect()->prepare('SELECT * FROM file_location WHERE name = :name');
    $stmt->execute(['name' => $name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insertRecord($name, $type, $path){
    $conn = parent::connect();
    $stmt = $conn->prepare('INSERT INTO file_location (name, type, path) VALUES (:name, :type, :path)');
    $stmt->execute(['name' => $name, 'type' => $type, 'path' => $path]);
    return $conn->lastInsertId();
  }
}
