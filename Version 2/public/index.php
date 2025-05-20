<?php
// Enable error reporting for debugging (remove in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../controllers/ArticleController.php';

$controller = new ArticleController();
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'article':
        $controller->article();
        break;
    case 'home':
    default:
        $controller->home();
        break;
}
?>