<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container-wrapper {
            width: 100%;
            min-height: 90vh;
            background-color: #343a40;
            color: white;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            height: 100%;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            background-color: #343a40;
            display: block;
        }

        .sidebar a:hover {
            background-color: #004091;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #343a40;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            color: white;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-menu {
            position: relative;
        }

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

        .content {
            padding: 20px;
            background-color: #ffffff;
            color: #000000;
            flex: 1;
            border-top-left-radius: 20px;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
            word-wrap: break-word;
            font-size: 14px;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .container {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>


<body>

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
    <div class="container-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="text-center text-white">Menu</h4>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title text-center">Xin chào ,</div>
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

            <div class="container">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0 text-center">Create News</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter news title" required>
                            </div>
                            <div class="form-group">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content" rows="5" required class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['NAME'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end my-4 gap-3">
                                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>