<?php
require_once 'Classes/Dbh.php';
require_once 'Classes/FileSystem.php';
echo "Current working directory: " . getcwd() . "<br>";
$fileSystem = new FileSystem(getcwd());
$fileSystem->scanAndRecordFileSystem(getcwd());
