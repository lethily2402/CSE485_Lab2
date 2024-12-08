<?php

require_once "C:/laragon/www/project01/tlunews/models/News.php";

class HomeController {
    // Hiển thị trang danh sách tin tức
    public function index() {
        $news = News::getAll(); // Lấy toàn bộ danh sách tin tức từ Model
        include "C:/laragon/www/project01/tlunews/views/home/index.php";
    }

    // Chức năng tìm kiếm tin tức
    public function search() {
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            // Lấy từ khóa tìm kiếm từ URL
            $query = htmlspecialchars($_GET['query']);

            // Tìm kiếm tin tức dựa vào từ khóa
            $news = News::searchByTitle($query);

            // Hiển thị kết quả tìm kiếm
            include "C:/laragon/www/project01/tlunews/views/home/search.php";
        } else {
            // Nếu không có từ khóa, chuyển về trang chủ
            header("Location: index.php");
        }
    }
}
  
