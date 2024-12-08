<?php
require_once 'config/database.php';
require_once 'controllers/NewsController.php';

$database = new Database();
$db = $database->getConnection();

$controller = new NewsController($db);

// PHP 5.x compatible version of null coalescing operator
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'show':
        $controller->show($id);
        break;
    case 'search':
        $controller->search();
        break;

    default:
        $controller->index();
        break;
}
