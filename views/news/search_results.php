<h1>Search Results</h1>
<a href="index.php">Back to All News</a>
<ul>
    <?php if (!empty($newsList)): ?>
        <?php foreach ($newsList as $news): ?>
            <li>
                <a href="?action=show&id=<?= htmlspecialchars($news->getId()) ?>">
                    <?= htmlspecialchars($news->getTitle()) ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No news articles found.</li>
    <?php endif; ?>
</ul>
