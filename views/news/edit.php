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
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';

        // Validate required fields
        if (empty($title) || empty($content)) {
            echo "Please fill in all required fields.";
        } else {
            // Handle image upload
            if ($image) {
                $targetPath = './uploads/' . $image;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    // Delete old image if exists
                    if (file_exists('./uploads/' . $news->getImage())) {
                        unlink('./uploads/' . $news->getImage());
                    }
                } else {
                    echo "Failed to upload image.";
                    $image = $news->getImage(); // Use old image on failure
                }
            } else {
                $image = $news->getImage(); // Keep old image if none uploaded
            }

            // Update news data
            $result = $newsService->updateNews($id, $title, $content, $image, $category_id);
            if ($result) {
                header("Location: index.php?message=News updated successfully");
                exit;
            } else {
                echo "Error updating news.";
            }
        }
    }
} else {
    echo "No news ID provided!";
    exit;
}
?>

        .user-menu ul {
            display: none;
            /* Ẩn menu */
            position: absolute;
            right: 0;
            top: 30px;
            list-style: none;
            background-color: white;
            color: #333;
            padding: 5px 10px;
            border-radius: 4px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-menu:hover ul {
            display: block;
            /* Hiển thị menu khi hover */
        }

        .user-menu li {
            padding: 5px 0;
        }

        .user-menu li a {
            color: #0056b3;
            text-decoration: none;
        }

    </style>
</head>
<body>
<div class="container-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="text-center text-white">Menu</h4>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">Xin chào ,</div>
                <div class="header-right">
                    <span><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></span>
                    <div class="user-menu">
                        <span style="cursor:pointer;">🔽</span>
                        <ul>
                            <li><a href="#" onclick="confirmLogout(event)">Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    <div class="content-container">
        <div class="header-title">Trang quản trị tin tức</div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title m-0">Edit News</h3>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                               placeholder="Enter news title" value="<?= htmlspecialchars($news->getTitle()) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" rows="5" required class="form-control"><?= htmlspecialchars($news->getContent()) ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <img src="./uploads/<?= htmlspecialchars($news->getImage()) ?>" width="100" height="100" class="mt-2"/>
                    </div>
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= (int)$category['id'] === (int)$news->getCategoryId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['NAME']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <a href="index.php" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>