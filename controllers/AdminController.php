<?php
// session_start();
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';


class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Lấy user từ database
            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Kiểm tra role (role = 1 là quản trị viên)
                if ($user['role'] == 1) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    header("Location: /views/admin/dashboard.php");
                    exit;
                } else {
                    $error = "Bạn không có quyền truy cập.";
                }
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }
        require '../views/admin/login.php';
    }
}
?>
