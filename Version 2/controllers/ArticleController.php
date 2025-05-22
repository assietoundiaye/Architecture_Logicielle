<?php
// Inclusion des modèles nécessaires
require_once '../models/Database.php';
require_once '../models/Article.php';
require_once '../models/Category.php';

class ArticleController {
    // Propriétés pour stocker les instances des modèles
    private $articleModel;
    private $categoryModel;

    // Constructeur de la classe
    public function __construct() {
        // Création d'une instance de Database et récupération de la connexion PDO
        $db = new Database();
        // Initialisation des modèles Article et Category
        $this->articleModel = new Article($db->getPdo());
        $this->categoryModel = new Category($db->getPdo());
    }

    // Méthode pour afficher la page d'accueil
    public function home() {
        // Récupération de l'ID de catégorie depuis l'URL (si présent)
        $categoryId = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;
        // Récupération des articles (filtrés par catégorie si nécessaire)
        $articles = $this->articleModel->getAllArticles($categoryId);
        // Récupération de toutes les catégories pour le menu
        $categories = $this->categoryModel->getAllCategories();
        // Inclusion de la vue home.php
        require '../views/home.php';
    }

    // Méthode pour afficher un article spécifique
    public function article() {
        // Récupération de l'ID d'article depuis l'URL
        $articleId = isset($_GET['id']) ? intval($_GET['id']) : null;
        // Vérification que l'ID est valide
        if (!$articleId) {
            die("Article non spécifié.");
        }
        // Récupération des détails de l'article
        $article = $this->articleModel->getArticleById($articleId);
        // Vérification que l'article existe
        if (!$article) {
            die("Article non trouvé.");
        }
        // Récupération de toutes les catégories pour le menu
        $categories = $this->categoryModel->getAllCategories();
        // Inclusion de la vue article.php
        require '../views/article.php';
    }

    // Méthode pour effectuer une recherche d'articles
    public function search() {
        // Récupération du terme de recherche depuis l'URL
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        // Recherche des articles correspondants
        $articles = $this->articleModel->searchArticles($searchTerm);
        // Récupération de toutes les catégories pour le menu
        $categories = $this->categoryModel->getAllCategories();
        // Inclusion de la vue home.php (qui affiche les résultats)
        require '../views/home.php';
    }
}
?>