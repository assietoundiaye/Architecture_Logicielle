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
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getArticleById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Article WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCommentsByArticleId($articleId) {
        $stmt = $this->pdo->prepare("SELECT * FROM Commentaire WHERE article_id = :article_id ORDER BY dateCreation DESC");
        $stmt->execute(['article_id' => $articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>