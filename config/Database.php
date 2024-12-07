<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'tintuc'; 
    private $username = 'root';
    private $password = ''; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Kiểm tra và thêm tài khoản quản trị viên nếu chưa có
            $this->createAdminAccount();

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    // Hàm kiểm tra và tạo tài khoản quản trị viên nếu chưa có
    private function createAdminAccount() {
        try {
            // Kiểm tra xem tài khoản quản trị viên đã tồn tại chưa
            $query = "SELECT COUNT(*) FROM users WHERE role = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                // Nếu chưa có tài khoản quản trị viên, tạo mới
                $username = "admin";
                $password = password_hash("admin123", PASSWORD_DEFAULT); // Mã hóa mật khẩu
                $role = 1; // Quản trị viên

                $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(['username' => $username, 'password' => $password, 'role' => $role]);

                echo "Tài khoản quản trị viên đã được tạo thành công!";
            } else {
                echo "Tài khoản quản trị viên đã tồn tại.";
            }

        } catch (PDOException $exception) {
            echo "Lỗi khi tạo tài khoản quản trị viên: " . $exception->getMessage();
        }
    }
}

// Sử dụng Database để tạo kết nối
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Failed to connect to the database.";
}
?>
