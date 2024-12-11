<?php
require_once 'db/index.php';
require_once 'app/models/FileSystemModel.php';
require_once 'app/controllers/SearchController.php';
require_once 'app/controllers/FileSystemController.php';  

// Define routes as an array of HTTP method and paths
$routes = [
  'GET' => [
      '/' => [SearchController::class, 'index'],
      '/scan' => [FileSystemController::class, 'scan'],
  ],
  'POST' => [
      '/search' => [SearchController::class, 'search'],
  ],
];

// Get the request URI and HTTP method
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];
// Normalize URI (remove trailing slashes except for the root path)
$requestUri = rtrim($requestUri, '/') ?: '/';

// Match route
if (isset($routes[$requestMethod][$requestUri])) {
    [$controller, $action] = $routes[$requestMethod][$requestUri];

    if (class_exists($controller) && method_exists($controller, $action)) {
        $instance = new $controller();
        $instance->$action();
    } else {
        http_response_code(404);
        echo "404 Not Found: Action '{$action}' not defined in '{$controller}'.";
    }
} else {
    http_response_code(404);
    echo "404 Not Found: The route '{$requestUri}' does not exist.";
}

