<?php

class Utility
{
  public function convertToSystemPath($path)
  {
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
  }

  public function formatFilePath($path)
  {
    $formattedPath = $this->convertToSystemPath($path);

    // If running on Windows, ensure the drive letter is uppercase
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $formattedPath = preg_replace_callback('/^[a-z]:/', function ($matches) {
        return strtoupper($matches[0]);
      }, $formattedPath);
    }

    return $formattedPath;
  }

  public function joinPaths($basePath, $endPath)
  {
    $basePath = rtrim($this->convertToSystemPath($basePath), DIRECTORY_SEPARATOR);
    $endPath = ltrim($this->convertToSystemPath($endPath), DIRECTORY_SEPARATOR);

    return $basePath . DIRECTORY_SEPARATOR . $endPath;
  }


  public function getPathType($path)
  {
    if (is_file($path)) {
      return 'file';
    } elseif (is_dir($path)) {
      return 'folder';
    } else {
      return 'unknown';
    }
  }
}
