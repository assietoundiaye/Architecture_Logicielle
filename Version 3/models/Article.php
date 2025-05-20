<?php
class Article {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllArticles($categoryId = null) {
        if ($categoryId) {
            $stmt = $this->pdo->prepare("SELECT * FROM Article WHERE categorie = :categorie ORDER BY dateCreation DESC");
            $stmt->execute(['categorie' => $categoryId]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM Article ORDER BY dateCreation DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Article WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchArticles($searchTerm) {
        if (empty($searchTerm)) {
            return $this->getAllArticles(); // Return all articles if search term is empty
        }
        $stmt = $this->pdo->prepare("SELECT * FROM Article WHERE titre LIKE :search OR contenu LIKE :search ORDER BY dateCreation DESC");
        $searchParam = "%$searchTerm%";
        $stmt->execute(['search' => $searchParam]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>