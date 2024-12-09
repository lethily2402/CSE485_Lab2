<?php
session_start();
// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <!-- Thêm Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <script>
        // Hàm xác nhận đăng xuất
        function confirmLogout(event) {
            event.preventDefault();
            var confirmLogout = confirm("Bạn có muốn đăng xuất không?");
            if (confirmLogout) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
        }

        .header {
            background-color: #343a40;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .header .header-title {
            font-size: 1.8rem;
            font-weight: bold;
            flex-grow: 1; /* Đảm bảo rằng tiêu đề sẽ chiếm hết không gian còn lại */
            text-align: center;
        }

        .header .user-menu {
            position: relative;
            cursor: pointer;
        }

        .header .user-menu ul {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            color: black;
            border: 1px solid #ccc;
            list-style: none;
            padding: 10px;
            display: none;
            width: 150px;
        }

        .header .user-menu:hover ul {
            display: block;
        }

        .header .user-menu ul li {
            padding: 5px 10px;
        }

        .header .user-menu ul li:hover {
            background-color: #f1f1f1;
        }

        /* Sidebar */
        .sidebar {
            background-color: #343a40;
            color: white;
            width: 200px;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 200px;
            padding: 20px;
        }

        .main-content h3 {
            font-size: 1.5rem;
            margin-top: 20px;
        }

        /* Header title */
        .header-title {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .header-right span {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Tiêu đề Header -->
        <div class="header-title">
            Trang quản trị
        </div>
        
        <!-- Phần thông tin người dùng và Logout -->
        <div class="header-right">
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <div class="user-menu">
                <span style="cursor:pointer;">🔽</span>
                <ul>
                    <li><a href="#" onclick="confirmLogout(event)">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Sidebar (Menu bên trái) -->
    <div class="sidebar">
        <h4 class="text-center">Menu</h4>
        <!-- Liên kết Quản lý tin tức đến index.php -->
        <a href="../../index.php"  font-size = >Quản lý tin tức</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h3>Chào mừng bạn đến với Trang quản trị tin tức dành cho admin!</h3>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
