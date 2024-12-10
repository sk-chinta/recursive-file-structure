<?php

class FileSystem {
  private $outputFile = 'file_structure_output.txt';
  public function __construct(){}

  public function scanDirectory($directoryPath) {
    // Open the file for writing
    $fileHandle = fopen($this->outputFile, 'w');
    if (!$fileHandle) {
        die("Unable to open file for writing: {$this->outputFile}");
    }

    // Start processing the directory
    $this->processDirectory($directoryPath, $fileHandle, $directoryPath);

    // Close the file
    fclose($fileHandle);
    echo "File structure written to {$this->outputFile} successfully.";
  }

  private function processDirectory($directoryPath, $fileHandle, $basePath) {
    // Normalize the directory path
    $normalizedDirectory = realpath($directoryPath);
    if (!$normalizedDirectory || !is_dir($normalizedDirectory)) {
        die("Invalid directory: {$directoryPath}");
    }

     // Scan the directory
     $entries = array_diff(scandir($normalizedDirectory), ['.', '..']);
     foreach ($entries as $entry) {
         $path = $normalizedDirectory . DIRECTORY_SEPARATOR . $entry;

         // Write the full path relative to the base path
         $relativePath = $this->getRelativePath($basePath, $path);
         fwrite($fileHandle, $relativePath . PHP_EOL);

         // If it's a directory, process recursively
         if (is_dir($path)) {
             $this->processDirectory($path, $fileHandle, $basePath);
         }
     }
  }

  private function getRelativePath($basePath, $fullPath) {
    // Replace the base path in the full path
    if (!$basePath || !$fullPath) {
        return $fullPath; // Return the original path if any input is null
    }

    $relativePath = str_replace($basePath, '', $fullPath);

    // Normalize slashes to use backslashes for Windows-style paths
    return str_replace(['/', '\\'], '\\', $basePath . $relativePath);
  }
}

$fileSystem = new FileSystem();
$fileSystem->scanDirectory(__DIR__);
?>