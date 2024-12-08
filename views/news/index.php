<h1>All News</h1>
<a href="?action=create">Create News</a>
<form action="?action=search" method="POST">
    <input type="text" name="keyword" placeholder="Search news..." required>
    <button type="submit">Search</button>
</form>
<ul>
    <?php
    require_once 'services/NewsService.php';
    require_once 'config/database.php';

    $database = new Database();
    $db = $database->getConnection();
    $newsService = new NewsService($db);

    $newsList = $newsService->getAllNews();
    foreach ($newsList as $news): ?>
        <li>
            <a href="?action=show&id=<?= $news->getId() ?>"><?= $news->getTitle() ?></a>
            <a href="?action=edit&id=<?= $news->getId() ?>">Edit</a>
            <a href="?action=delete&id=<?= $news->getId() ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>