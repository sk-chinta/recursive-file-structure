<?php
require_once './app/models/FileSystemModel.php';

class SearchController {
    private $fileSystemModel;
    public function __construct() {
      $this->fileSystemModel = new FileSystemModel();
    }

    // Default action to display the search form
    public function index() {
        $results = []; // No results initially
        require_once __DIR__ . '/../views/search.php';
    }

    public function search() {
        $query = $_POST['search'] ?? '';
        $results = [];
        if (!empty($query)) {
            $results = $this->fileSystemModel->searchPaths($query);
        }

        // Render the view
        require_once __DIR__ . '/../views/search.php';
    }
}