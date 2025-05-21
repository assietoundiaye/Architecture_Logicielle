<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['titre']) ?> École Supérieure Polytechnique de dakar</title>
    <link rel="stylesheet" href="../views/css/index2.css">
</head>
<body>
    <nav class="custom-nav">
        <div class="nav-container">
            <a class="nav-brand" href="index.php">
                <img src="../public/images/img2.png" alt="Logo" width="45" height="30">
                École Supérieure Polytechnique
            </a>
            <div class="nav-content">
                <ul class="nav-list">
                    <li class="nav-item"><a href="index.php" class="nav-link active">Accueil</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contacts</a></li>
                </ul>
                <form class="search-form" role="search">
                    <input class="search-input" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn-custom" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="actualites" id="actualites">
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <article>
                <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
                <small>Publié le : <?= htmlspecialchars($article['dateCreation']) ?></small>
            </article>
            <a href="index.php" class="btn-custom">Retour aux actualités</a>
        </div>

        <div class="sidebar">
            <h2>Catégories</h2>
            <ul>
                <li><a href="index.php">Tous</a></li>
                <?php foreach ($categories as $categorie): ?>
                    <li><a href="index.php?categorie=<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['libelle']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>