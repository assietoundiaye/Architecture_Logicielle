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
$stmt = $pdo->prepare("SELECT a.*, c.libelle AS categorie_nom
                     FROM Article a
                     LEFT JOIN Categorie c ON a.categorie = c.id
                     WHERE a.id = :id");
$stmt->execute(['id' => $articleId]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    echo "Article non trouvé.";
    exit;
}

// Récupérer les catégories (pour la sidebar)
$query = $pdo->query("SELECT * FROM Categorie");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer des articles similaires (de la même catégorie)
$stmtSimilar = $pdo->prepare("SELECT * FROM Article
                             WHERE categorie = :categorie
                             AND id != :id
                             ORDER BY dateCreation DESC
                             LIMIT 3");
$stmtSimilar->execute([
    'categorie' => $article['categorie'],
    'id' => $articleId
]);
$similarArticles = $stmtSimilar->fetchAll(PDO::FETCH_ASSOC);
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
                <li class="nav-item"><a href="Acceuil.php" class="nav-link">Accueil</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contacts</a></li>
            </ul>
            <form class="search-form" role="search" method="GET" action="Acceuil.php">
                <input class="search-input" type="search" name="q" placeholder="Rechercher" aria-label="Search">
                <button class="btn-custom" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="main-container">
    <div class="actualites" id="actualites">
        <h2><?= htmlspecialchars($article['titre']) ?></h2>
        <div class="article-meta">
            <small>
                Catégorie : <a href="Acceuil.php?categorie=<?= $article['categorie'] ?>"><?= htmlspecialchars($article['categorie_nom'] ?? 'Non catégorisé') ?></a> |
                Publié le : <?= htmlspecialchars($article['dateCreation']) ?>
            </small>
        </div>
        <article>
            <div class="article-content">
                <?= nl2br(htmlspecialchars($article['contenu'])) ?>
            </div>
        </article>

        <?php if (!empty($similarArticles)): ?>
        <div class="articles-similaires">
            <h3>Articles similaires</h3>
            <ul>
                <?php foreach ($similarArticles as $similarArticle): ?>
                <li>
                    <a href="article.php?id=<?= $similarArticle['id'] ?>">
                        <?= htmlspecialchars($similarArticle['titre']) ?>
                    </a>
                    <small>(<?= htmlspecialchars($similarArticle['dateCreation']) ?>)</small>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <a href="Acceuil.php" class="btn-custom">Retour aux actualités</a>
    </div>

    <div class="sidebar">
        <h2>Catégories</h2>
        <ul>
            <li><a href="Acceuil.php">Tous</a></li>
            <?php foreach ($categories as $categorie): ?>
                <li>
                    <a href="Acceuil.php?categorie=<?= $categorie['id'] ?>"
                       <?= $article['categorie'] == $categorie['id'] ? 'class="active"' : '' ?>>
                        <?= htmlspecialchars($categorie['libelle']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>