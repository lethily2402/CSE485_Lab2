<?php
require_once 'config/Database.php';
require_once 'controllers/NewsController.php';
require_once 'controllers/AdminController.php';

$database = new Database();
$db = $database->getConnection();

$newsController = new NewsController($db);
$adminController = new AdminController();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'news';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($controller) {
    case 'admin':
        switch ($action) {
            case 'login':
                $adminController->login($db);
                break;
            case 'logout':
                session_start();
                session_destroy();
                header("Location: ?controller=admin&action=login");
                break;
            default:
                echo "Hành động không hợp lệ cho controller Admin.";
        }
        break;

    case 'news':
    default:
        switch ($action) {
            case 'create':
                $newsController->create();
                break;
            case 'edit':
                $newsController->edit($id);
                break;
            case 'delete':
                $newsController->delete($id);
                break;
            case 'show':
                $newsController->show($id);
                break;
            case 'search':
                $newsController->search();
                break;
            default:
                $newsController->index();
                break;
        }
        break;
}
?>
