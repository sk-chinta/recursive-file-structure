<?php
require_once __DIR__ . '/layout.php'; // Base layout

startLayout('File System Search'); // Pass the page title
?>

<form method="POST" action="/search" class="search-box">
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
        <p>No results found for "<?= htmlspecialchars($_POST['search']); ?>"</p>
    <?php endif; ?>
</div>

<?php endLayout(); ?>