<?php

require_once '../controllers/ArticleController.php';

$controller = new ArticleController();
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'article':
        $controller->article();
        break;
    case 'search':
        $controller->search();
        break;
    case 'home':
    default:
        $controller->home();
        break;
}
?>