<?php
require_once 'services/NewsService.php';

class NewsController
{
    private $newsService;

    public function __construct($db) {
        $this->newsService = new NewsService($db);
    }

    public function index() {
        $newsList = $this->newsService->getAllNews();
        require_once 'views/news/index.php';
    }

    public function show($id) {
        $news = $this->newsService->getNewsById($id);
        require_once 'views/news/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_POST['image'];
            $category_id = $_POST['category_id'];

            $this->newsService->createNews($title, $content, $image, $category_id);
            header("Location: index.php");
        }
        require_once 'views/news/create.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_POST['image'];
            $category_id = $_POST['category_id'];

            $this->newsService->updateNews($id, $title, $content, $image, $category_id);
            header("Location: index.php");
        } else {
            $news = $this->newsService->getNewsById($id);
            require_once 'views/news/edit.php';
        }
    }

    public function delete($id) {
        $this->newsService->deleteNews($id);
        header("Location: index.php");
    }
    public function search()
    {
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $newsList = $this->newsService->searchNews($keyword);
        require 'views/news/search_results.php';
    }

}
