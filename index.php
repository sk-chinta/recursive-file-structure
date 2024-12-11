<?php
require_once 'Classes/Dbh.php';
require_once 'Classes/FileSystem.php';

// Process the search
$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['search'] ?? '';
    if (!empty($query)) {
        $fileSystem = new FileSystem(getcwd());
        $results = $fileSystem->searchPaths($query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My PHP Website</title>
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .results {
            margin-top: 20px;
        }
        .results ul {
            list-style-type: none;
            padding: 0;
        }
        .results li {
            margin: 5px 0;
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
  <h1>Search File System</h1>
    <form method="POST" class="search-box">
        <input type="text" name="search" placeholder="Enter search term" required style="width: 300px; padding: 10px;">
        <button type="submit" style="padding: 10px;">Search</button>
    </form>

    <div class="results">
        <h2>Search Results:</h2>
        <?php if (!empty($results)): ?>
            <ul>
                <?php foreach ($results as $result): ?>
                    <li><?= htmlspecialchars($result['path']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No results found for "<?= htmlspecialchars($query); ?>"</p>
        <?php endif; ?>
    </div>
</body>
</html>