<?php
require_once './config/database.php';
require_once './services/NewsService.php';
require_once './models/News.php';
require_once './models/Category.php';

$database = new Database();
$db = $database->getConnection();
$newsService = new NewsService($db);

// Get categories for the dropdown
$query = "SELECT * FROM categories";
$stmt = $db->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get news data by ID
    $news = $newsService->getNewsById($id);
    if (!$news) {
        echo "News not found!";
        exit;
    }

    // Update news
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        $category_id = $_POST['category_id'];

        // If an image is uploaded, move it to the uploads folder
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' . $image);
        } else {
            $image = $news->getImage(); // Keep the existing image if no new one is uploaded
        }

        $result = $newsService->updateNews($id, $title, $content, $image, $category_id);
        if ($result) {
            echo "News updated successfully!";
        } else {
            echo "Error updating news!";
        }
    }
} else {
    echo "No news ID provided!";
    exit;
}
?>

<h1>Edit News</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="title">Title</label><br>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($news->getTitle()) ?>" required><br><br>

    <label for="content">Content</label><br>
    <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($news->getContent()) ?></textarea><br><br>

    <label for="image">Image</label><br>
    <input type="file" id="image" name="image"><br><br>
    <p>Current Image: <img src="./uploads/<?= htmlspecialchars($news->getImage()) ?>" width="100" height="100" /></p>



    <label for="category_id">Category</label><br>
    <select id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>" <?= $category['id'] == $news->getCategoryId() ? 'selected' : '' ?>>
                <?= $category['name'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Update News</button>
</form>
