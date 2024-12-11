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


  public function recordFromFile($filename) {
    if (!file_exists($filename)) {
        die("File not found: $filename");
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {      
      // Only process paths that are within the current directory
      // Ensure the path starts with the current directory
      if (strpos($line, $this->currentDir) === 0) {
        $this->insertPath($line, $this->currentDir);
      }
    }

    echo "File structure recorded successfully into the database.";
  }

  private function insertPath($path, $baseDirectory) {
    $relativePath = str_replace($baseDirectory, '', $path); // Get the relative path
    $segments = explode(DIRECTORY_SEPARATOR, $relativePath); // Split into parts

    $fullPath = $this->utility->joinPaths($baseDirectory, $relativePath);
    $baseSegment = explode(DIRECTORY_SEPARATOR, $baseDirectory);
    foreach ($segments as $segment) {
      empty($segment) ? $segment = end($baseSegment) : $segment;

      // Check if the folder/file already exists
      $existingRecord = $this->findRecord($segment);
      if(!$existingRecord){
        // Otherwise, insert new folder/file
        $type = $this->utility->getPathType($fullPath); // Determine file or folder
        $this->insertRecord($segment, $type, $path);
      }      
    }

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
