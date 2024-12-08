<?php
require_once 'models/News.php';

class NewsService
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllNews()
    {
        $query = "SELECT * FROM news";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $newsList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $newsList[] = new News(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['image']
            );
        }
        return $newsList;
    }

    public function getNewsById($id)
    {
        $query = "SELECT * FROM news WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new News(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['image']
            );
        }
        return null;
    }

    public function createNews($title, $content, $image, $category_id)
    {
        $query = "INSERT INTO news (title, content, image, category_id, created_at) 
                  VALUES (:title, :content, :image, :category_id, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    public function updateNews($id, $title, $content, $image, $category_id)
    {
        $query = "UPDATE news 
                  SET title = :title, content = :content, image = :image, category_id = :category_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    public function deleteNews($id) {
        $query = "DELETE FROM news WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
