
<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        // Kết nối đến cơ sở dữ liệu
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy thông tin người dùng theo username
    public function getUserByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
