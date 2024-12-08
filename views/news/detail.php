<?php
// Kiểm tra xem dữ liệu bài viết có được truyền từ Controller không
if (!isset($news)) {
    echo "<p>Bài viết không tồn tại.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-3"><?= htmlspecialchars($news['title']) ?></h1>
    <p class="text-muted">Ngày đăng: <?= date('d-m-Y H:i:s', strtotime($news['created_at'])) ?></p>
    <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="img-fluid mb-4">
    <div class="content">
        <?= nl2br(htmlspecialchars($news['content'])) ?>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
