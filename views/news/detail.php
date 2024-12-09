<?php
require_once '../../config/database.php';
require_once '../../services/NewsService.php';
require_once '../../models/News.php';

$database = new Database();
$db = $database->getConnection();
$newsService = new NewsService($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch news by ID
    $news = $newsService->getNewsById($id);
    if (!$news) {
        echo "<h2>News not found!</h2>";
        exit;
    }
} else {
    echo "<h2>No news ID provided!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Details</title>
</head>
<body>
<h1><?= htmlspecialchars($news->getTitle()) ?></h1>
<p><strong>Category:</strong> <?= htmlspecialchars($news->getCategoryName()) ?></p>
<p><strong>Published On:</strong> <?= htmlspecialchars($news->getCreatedAt()) ?></p>
<hr>
<div>
    <p><?= nl2br(htmlspecialchars($news->getContent())) ?></p>
</div>
<hr>
<?php if ($news->getImage()): ?>
    <div>
        <img src="../../uploads/<?= htmlspecialchars($news->getImage()) ?>" alt="<?= htmlspecialchars($news->getTitle()) ?>" style="max-width:100%; height:auto;">
    </div>
<?php endif; ?>
<br>
<a href="index.php">Back to All News</a>
</body>
</html>
