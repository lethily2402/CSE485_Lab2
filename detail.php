<div class="container mt-5">
    <div class="card">
        <!-- Check if image exists -->
        <img src="<?= isset($news['image']) ? htmlspecialchars($news['image']) : 'default-image.jpg' ?>" class="card-img-top" alt="Hình ảnh bài viết">
        <div class="card-body">
            <!-- Sanitize title and content -->
            <h1 class="card-title"><?= htmlspecialchars($news['title']) ?></h1>
            <p class="card-text"><?= htmlspecialchars($news['content']) ?></p>
            <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>