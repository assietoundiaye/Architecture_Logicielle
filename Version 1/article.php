<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'mglsi_news';
$user = 'mglsi_user';
$password = 'passer';

try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : Impossible de se connecter à la base de données.";
    exit;
}

// Récupérer l'ID de l'article depuis l'URL
$articleId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$articleId) {
    echo "Article non spécifié.";
    exit;
}

// Récupérer l'article
$stmt = $pdo->prepare("SELECT * FROM Article WHERE id = :id");
$stmt->execute(['id' => $articleId]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    echo "Article non trouvé.";
    exit;
}

// Récupérer les catégories (pour la sidebar)
$query = $pdo->query("SELECT * FROM Categorie");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['titre']) ?> -- École Supérieure Polytechnique</title>
    <link rel="stylesheet" href="css/index2.css">
</head>
<body>

<!-- Barre de navigation -->
<nav class="custom-nav">
    <div class="nav-container">
        <a class="nav-brand" href="Acceuil.php">
            <img src="images/img2.png" alt="Logo" width="45" height="30">
            École Supérieure Polytechnique
        </a>
        <div class="nav-content">
            <ul class="nav-list">
                <li class="nav-item"><a href="Acceuil.php" class="nav-link active">Accueil</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contacts</a></li>
            </ul>
            <form class="search-form" role="search">
                <input class="search-input" type="search" placeholder="Rechercher" aria-label="Search">
                <button class="btn-custom" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="main-container">
    <div class="actualites" id="actualites">
        <h2><?= htmlspecialchars($article['titre']) ?></h2>
        <article>
            <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
            <small>Publié le : <?= htmlspecialchars($article['dateCreation']) ?></small>
        </article>
        <a href="Acceuil.php" class="btn-custom">Retour aux actualités</a>
    </div>

    <div class="sidebar">
        <h2>Catégories</h2>
        <ul>
            <li><a href="Acceuil.php">Tous</a></li>
            <?php foreach ($categories as $categorie): ?>
                <li><a href="Acceuil.php?categorie=<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['libelle']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>