class HomeController {
public function index() {
$news = News::getAll();
include "views/home/index.php";
}

public function search() {
$keyword = $_GET['keyword'] ?? '';
$news = News::search($keyword);
include "views/home/index.php";
}
}