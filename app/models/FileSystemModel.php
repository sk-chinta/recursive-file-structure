<?php
require_once './utility/index.php';

class FileSystemModel extends Dbh
{
  public function __construct() {}

  public function findRecord($name)
  {
    $stmt = parent::connect()->prepare('SELECT * FROM file_location WHERE name = :name');
    $stmt->execute(['name' => $name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insertRecord($name, $type, $path)
  {
    $conn = parent::connect();
    $stmt = $conn->prepare('INSERT INTO file_location (name, type, path) VALUES (:name, :type, :path)');
    $stmt->execute(['name' => $name, 'type' => $type, 'path' => $path]);
    return $conn->lastInsertId();
  }

  public function searchPaths($query)
  {
    $conn = parent::connect();
    $stmt = $conn->prepare("SELECT path FROM file_location WHERE path LIKE :query");
    $searchQuery = "%" . $query . "%";
    $stmt->execute(['query' => $searchQuery]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
