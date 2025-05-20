<?php
class Category {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCategories() {
        $query = $this->pdo->query("SELECT * FROM Categorie");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>