<?php


$database = new Database();
$db = $database->getConnection();
$newsService = new NewsService($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get news data by ID
    $news = $newsService->getNewsById($id);
    if (!$news) {
        echo "News not found!";
        exit;
    }
} else {
    echo "No news ID provided!";
    exit;
}
?>

<h1><?= htmlspecialchars($news->getTitle()) ?></h1>
<p><strong>Category:</strong> <?= htmlspecialchars($news->getCategoryName()) ?></p>
<p><strong>Published on:</strong> <?= htmlspecialchars($news->getCreatedAt()) ?></p>
<p><strong>Content:</strong></p>
<p><?= nl2br(htmlspecialchars($news->getContent())) ?></p>
<p><strong>Image:</strong></p>
<img src="./uploads/<?= htmlspecialchars($news->getImage()) ?>" alt="<?= htmlspecialchars($news->getTitle()) ?>" width="300"><br><br>

<a href="?action=index">Back to All News</a>
