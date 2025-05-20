<?php
require_once '../models/Database.php';
require_once '../models/Article.php';
require_once '../models/Category.php';

class ArticleController {
    private $articleModel;
    private $categoryModel;

    public function __construct() {
        $db = new Database();
        $this->articleModel = new Article($db->getPdo());
        $this->categoryModel = new Category($db->getPdo());
    }

    public function home() {
        $categoryId = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;
        $articles = $this->articleModel->getAllArticles($categoryId);
        $categories = $this->categoryModel->getAllCategories();
        require '../views/home.php';
    }

    public function article() {
        $articleId = isset($_GET['id']) ? intval($_GET['id']) : null;
        if (!$articleId) {
            die("Article non spécifié.");
        }
        $article = $this->articleModel->getArticleById($articleId);
        if (!$article) {
            die("Article non trouvé.");
        }
        $categories = $this->categoryModel->getAllCategories();
        require '../views/article.php';
    }
}
?>