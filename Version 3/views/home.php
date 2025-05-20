<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="../views/css/index2.css">
</head>
<body>
    <nav class="custom-nav">
        <div class="nav-container">
            <a class="nav-brand" href="index.php">
                <img src="images/img2.png" alt="Logo" width="45" height="30">
                École Supérieure Polytechnique
            </a>
            <div class="nav-content">
                <ul class="nav-list">
                    <li class="nav-item"><a href="index.php" class="nav-link active">Accueil</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contacts</a></li>
                </ul>
                <form class="search-form" role="search" method="get" action="index.php">
                    <input class="search-input" type="search" name="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn-custom" type="submit">Rechercher</button>
                    <input type="hidden" name="action" value="search">
                </form>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <?php if (isset($articles) && is_array($articles) && count($articles) > 0): ?>
            <div class="actualites" id="actualites">
                <h2>Actualités</h2>
                <?php foreach ($articles as $article): ?>
                    <article class="article-preview">
                        <h3><a href="index.php?action=article&id=<?= $article['id'] ?>"><?= htmlspecialchars($article['titre']) ?></a></h3>
                        <p>
                            <?php
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
            </div>
        <?php else: ?>
            <div class="actualites" id="actualites">
                <h2>Actualités</h2>
                <p>Aucun article disponible pour cette catégorie.</p>
            </div>
        <?php endif; ?>

        <div class="sidebar">
            <h2>Catégories</h2>
            <ul>
                <li><a href="index.php" <?= !isset($_GET['categorie']) ? 'class="active"' : '' ?>>Tous</a></li>
                <?php if (isset($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $categorie): ?>
                        <li><a href="index.php?categorie=<?= $categorie['id'] ?>" <?= isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id'] ? 'class="active"' : '' ?>><?= htmlspecialchars($categorie['libelle']) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><p>Aucune catégorie disponible.</p></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>