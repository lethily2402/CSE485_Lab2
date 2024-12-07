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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $category_id = $_POST['category_id'];

    // Move the uploaded image to a folder
    if (move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' . $image)) {
        $result = $newsService->createNews($title, $content, $image, $category_id);
        if ($result) {
            echo "News created successfully!";
        } else {
            echo "Error creating news!";
        }
    } else {
        echo "Failed to upload image!";
    }
}
?>

<h1>Create News</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="title">Title</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="content">Content</label><br>
    <textarea id="content" name="content" rows="5" required></textarea><br><br>

    <label for="image">Image</label><br>
    <input type="file" id="image" name="image" required><br><br>

    <label for="category_id">Category</label><br>
    <select id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Create News</button>
</form>
