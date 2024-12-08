<?php

class homeController {
    public function index() {
        $news

        include APP_ROOT . "views/home/index.php";
    }
    public function viewsDetail($id) {
        // Truy vấn bài viết theo ID
        $newsDetail = $this->getNewsDetail($id);

        if ($newsDetail) {
            // Nếu bài viết tồn tại, hiển thị trong view
            include 'views/news/detail.php';  // Chuyển kết quả đến view detail.php
        } else {
            // Nếu không tìm thấy bài viết, chuyển về trang chủ hoặc trang lỗi
            echo "Bài viết không tồn tại.";
            // header('Location: index.php'); // Bạn có thể chuyển hướng nếu muốn
            exit;
        }
    }

    // Method để lấy thông tin chi tiết bài viết từ cơ sở dữ liệu
    private function getNewsDetail($id) {
        // Kết nối với cơ sở dữ liệu (dùng PDO hoặc MySQLi)
        $db = new Database();
        $conn = $db->connect(); // Giả sử bạn có một lớp Database để kết nối với DB

        // Truy vấn SQL để lấy bài viết theo ID
        $query = "SELECT * FROM news WHERE id = :id";

        // Sử dụng PDO để chuẩn bị và thực thi truy vấn
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);  // Liên kết ID bài viết với tham số
        $stmt->execute();

        // Lấy kết quả và trả về
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Trả về thông tin bài viết
    }
}
