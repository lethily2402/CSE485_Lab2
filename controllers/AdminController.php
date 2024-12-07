<?php
session_start();
require_once '../models/User.php';
require_once '../config/Database.php';

class AdminController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Trang đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Kiểm tra role của user (quản trị viên có role = 1)
                if ($user['role'] == 1) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Điều hướng đến trang dashboard
                    header("Location: /tlunews/views/admin/dashboard.php");
                    exit;
                } else {
                    $error = "Bạn không có quyền truy cập vào khu vực quản trị.";
                    require_once 'views/admin/login.php';
                    exit;
                }
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                require_once 'views/admin/login.php';
            }
        } else {
            require_once 'views/admin/login.php';
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /tlunews/?controller=admin&action=login");
        exit;
    }

    // Trang Dashboard quản trị viên
    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: /tlunews/index.php?controller=admin&action=login");
            exit;
        }
        require_once '../views/admin/dashboard.php';  // Đảm bảo rằng đường dẫn đến file này là đúng
    }
}
