<?php
require_once './config/database.php';
require_once './services/NewsService.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $database = new Database();
    $db = $database->getConnection();
    $newsService = new NewsService($db);

    // Xóa bài viết
    if ($newsService->deleteNews($id)) {
        header("Location: index.php?message=Tin tức đã được xóa thành công");
    } else {
        header("Location: index.php?message=Không thể xóa bài viết");
    }
    exit;
} else {
    header("Location: index.php?message=ID không hợp lệ");
    exit;
}
