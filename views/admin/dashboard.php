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
    <script>
        // Hàm xác nhận đăng xuất
        function confirmLogout(event) {
            // Ngừng sự kiện mặc định của link
            event.preventDefault();

            // Hiển thị popup xác nhận
            var confirmLogout = confirm("Bạn có muốn đăng xuất không?");
            if (confirmLogout) {
                // Nếu người dùng chọn "OK", chuyển hướng đến trang logout
                window.location.href = "logout.php";
            } else {
                // Nếu người dùng chọn "Cancel", không làm gì cả
                return false;
            }
        }
    </script>
</head>
<body>
    <h2>Chào mừng bạn đến với trang quản trị!</h2>
    <p>Đây là trang Dashboard dành cho quản trị viên.</p>

    <!-- Liên kết đăng xuất, sẽ gọi hàm xác nhận khi nhấn vào -->
    <a href="#" onclick="confirmLogout(event)">Đăng xuất</a>
</body>
</html>
