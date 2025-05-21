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

// Vérifier si une recherche a été effectuée
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
$categoryId = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;

// Construction de la requête SQL selon les paramètres
if (!empty($searchTerm)) {
    // Recherche par mot-clé
    if ($categoryId) {
        // Recherche par mot-clé dans une catégorie spécifique
        $stmt = $pdo->prepare("SELECT * FROM Article WHERE (titre LIKE :search OR contenu LIKE :search) AND categorie = :categorie ORDER BY dateCreation DESC");
        $stmt->execute([
            'search' => '%' . $searchTerm . '%',
            'categorie' => $categoryId
        ]);
    } else {
        // Recherche par mot-clé dans toutes les catégories
        $stmt = $pdo->prepare("SELECT * FROM Article WHERE titre LIKE :search OR contenu LIKE :search ORDER BY dateCreation DESC");
        $stmt->execute(['search' => '%' . $searchTerm . '%']);
    }
} else {
    // Affichage normal sans recherche
    if ($categoryId) {
        // Articles d'une catégorie spécifique
        $stmt = $pdo->prepare("SELECT * FROM Article WHERE categorie = :categorie ORDER BY dateCreation DESC");
        $stmt->execute(['categorie' => $categoryId]);
    } else {
        // Tous les articles
        $stmt = $pdo->query("SELECT * FROM Article ORDER BY dateCreation DESC");
    }
}

$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page -- d'accueil</title>
    <link rel="stylesheet" href="css/index2.css">
</head>
<body>

<!-- Barre de navigation -->
<nav class="custom-nav">
    <div class="nav-container">
        <a class="nav-brand" href="Acceuil.php">
            <img src="images/img2.png" alt="Logo" width="45" height="30">
            École Supérieure Polytechnique de dakar
        </a>
        <div class="nav-content">
            <ul class="nav-list">
                <li class="nav-item"><a href="Acceuil.php" class="nav-link active">Accueil</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contacts</a></li>
            </ul>
            <form class="search-form" role="search" method="GET" action="Acceuil.php">
                <!-- Maintenir la catégorie si elle est déjà sélectionnée -->
                <?php if ($categoryId): ?>
                <input type="hidden" name="categorie" value="<?= $categoryId ?>">
                <?php endif; ?>
                <input class="search-input" type="search" name="q" placeholder="Rechercher"
                       aria-label="Search" value="<?= htmlspecialchars($searchTerm) ?>">
                <button class="btn-custom" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="main-container">
    <div class="actualites" id="actualites">
        <h2>Actualités<?= !empty($searchTerm) ? ' - Résultats pour "' . htmlspecialchars($searchTerm) . '"' : '' ?></h2>
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
            <p>Aucun article disponible<?= !empty($searchTerm) ? ' pour cette recherche.' : ' pour cette catégorie.' ?></p>
        <?php endif; ?>
    </div>

    <div class="sidebar">
        <h2>Catégories</h2>
        <ul>
            <li><a href="Acceuil.php<?= !empty($searchTerm) ? '?q=' . urlencode($searchTerm) : '' ?>" <?= !isset($_GET['categorie']) ? 'class="active"' : '' ?>>Tous</a></li>
            <?php foreach ($categories as $categorie): ?>
                <li>
                    <a href="Acceuil.php?categorie=<?= $categorie['id'] ?><?= !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : '' ?>"
                       <?= isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id'] ? 'class="active"' : '' ?>>
                        <?= htmlspecialchars($categorie['libelle']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>