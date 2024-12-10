<?php
// Bắt đầu hoặc tiếp tục phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
    header("Location: CSE485_TH2/views/admin/login.php");
    exit; // Dừng tiếp tục xử lý file hiện tại
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Dashboard</title>
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
                <div class="header-title">Quản lý tin tức</div>
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

            <!-- Content -->
            <div class="content">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title m-0">All News</h3>
                            <a href="?action=create" class="btn btn-primary">Create News</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th class="text-center" scope="col">Content</th>
                                    <th class="text-center" scope="col">Category</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                require_once 'services/NewsService.php';
                                require_once 'config/database.php';

                                $database = new Database();
                                $db = $database->getConnection();
                                $newsService = new NewsService($db);

                                $newsList = $newsService->getAllNews();
                                foreach ($newsList as $news): ?>
                                    <tr>
                                        <td class="text-center">
                                            <img class="rounded-circle object-fit-cover" style="width: 50px; height: 50px;"
                                                src="uploads/<?= $news->getImage() ?>" alt="News Image">
                                        </td>
                                        <td><?= $news->getTitle() ?></td>
                                        <td class="text-center"><?= $news->getContent() ?></td>
                                        <td class="text-center"><?= $news->getCategoryId() ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-outline-primary" href="?action=show&id=<?= $news->getId() ?>"><i class="fa-solid fa-eye"></i></a>
                                            <a class="btn btn-sm btn-outline-primary" href="?action=edit&id=<?= $news->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirmDelete(<?= $news->getId() ?>)"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        function confirmDelete(newsId) {
            const userConfirmed = confirm('Bạn có chắc chắn muốn xóa bài viết này không?');
            if (userConfirmed) {
                window.location.href = `delete.php?id=${newsId}`;
            }
        }
    </script>
</body>
</html>
