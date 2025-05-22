<?php
/**
 * Classe Database - Gère la connexion à la base de données MySQL via PDO
 */
class Database {
    // Configuration de la connexion à la base de données
    private $host = 'localhost';      // Hôte de la base de données
    private $dbname = 'mglsi_news';  // Nom de la base de données
    private $user = 'mglsi_user';     // Nom d'utilisateur MySQL
    private $password = 'passer';     // Mot de passe MySQL
    private $pdo;                    // Objet PDO pour la connexion

    /**
     * Constructeur - Établit la connexion à la base de données
     * @throws PDOException Si la connexion échoue
     */
    public function __construct() {
        try {
            // Chaîne de connexion DSN (Data Source Name)
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";

            // Création de l'instance PDO
            $this->pdo = new PDO($dsn, $this->user, $this->password);

            // Configuration des attributs PDO :
            // - ERRMODE_EXCEPTION pour générer des exceptions en cas d'erreur
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Note: On pourrait aussi configurer d'autres attributs comme :
            // - ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut
            // - ATTR_EMULATE_PREPARES pour désactiver l'émulation des requêtes préparées

        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message et arrêter le script
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Getter pour récupérer l'objet PDO
     * @return PDO L'instance de connexion à la base de données
     */
    public function getPdo() {
        return $this->pdo;
    }
}
?>