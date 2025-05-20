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

// Récupération des catégories
$query = $pdo->query("SELECT * FROM Categorie");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupération des articles (par défaut tous)
$categoryId = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;

if ($categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM Article WHERE categorie = :categorie ORDER BY dateCreation DESC");
    $stmt->execute(['categorie' => $categoryId]);
} else {
    $stmt = $pdo->query("SELECT * FROM Article ORDER BY dateCreation DESC");
}
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'acceuil</title>
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
                <li class="nav-item"><a href="#" class="nav-link active">Accueil</a></li>
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
        <h2>Actualités</h2>
        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <article class="article-preview">
                    <h3><a href="article.php?id=<?= $article['id'] ?>"><?= htmlspecialchars($article['titre']) ?></a></h3>
                    <p>
                        <?php
                        // Afficher un extrait du contenu (par exemple, les 100 premiers caractères)
                        $extrait = substr($article['contenu'], 0, 100);
                        if (strlen($article['contenu']) > 100) {
                            $extrait .= '...';
                        }
                        echo nl2br(htmlspecialchars($extrait));
                        ?>
                    </p>
                    <small>Publié le : <?= htmlspecialchars($article['dateCreation']) ?></small>
                </article>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article disponible pour cette catégorie.</p>
        <?php endif; ?>
    </div>

    <div class="sidebar">
        <h2>Catégories</h2>
        <ul>
            <li><a href="Acceuil.php" <?= !isset($_GET['categorie']) ? 'class="active"' : '' ?>>Tous</a></li>
            <?php foreach ($categories as $categorie): ?>
                <li><a href="Acceuil.php?categorie=<?= $categorie['id'] ?>" <?= isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id'] ? 'class="active"' : '' ?>><?= htmlspecialchars($categorie['libelle']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>