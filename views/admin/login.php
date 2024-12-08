<?php
session_start();
require_once '../../models/User.php';
require_once '../../config/Database.php';

// Tạo kết nối database
$database = new Database();
$db = $database->getConnection();

// Khởi tạo model User
$userModel = new User($db);

$error = null;

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra thông tin người dùng
    $user = $userModel->getUserByUsername($username);

    if ($user && ($password == $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['ROLE'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị viên</title>
    <style>
        /* Reset các kiểu mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container đăng nhập */
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Tiêu đề */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Thông báo lỗi */
        .error {
            color: red;
            margin-bottom: 15px;
        }

        /* Form */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Nhóm trường input */
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Input */
        input {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        /* Button đăng nhập */
        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Liên kết đăng ký */
        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            text-decoration: none;
            color: #007bff;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Đăng nhập quản trị viên</h2>

        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>

        <form method="POST" action="?controller=admin&action=login" class="login-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" placeholder="Nhập tên đăng nhập" required />
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required />
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>

</html>