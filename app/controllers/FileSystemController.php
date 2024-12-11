<?php
require_once './Classes/FileSystem.php';

class FileSystemController {
  private $currentDir;
  private $fileSystem;
  
  public function __construct(){
    $this->currentDir = getcwd();
    $this->fileSystem = new FileSystem();
  }

  public function scan() {
    echo "Current working directory: " . $this->currentDir . "<br>";
    $directoryPath = $_GET['directory'] ?? $this->currentDir;
    $this->fileSystem->scanAndRecordFileSystem($directoryPath);
  }
}
