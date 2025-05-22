<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['titre']) ?> - École Supérieure Polytechnique</title>
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
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="actualites" id="actualites">
            <h2><?= htmlspecialchars($article['titre']) ?></h2>

            <?php if (!empty($article['image'])): ?>
                <div class="article-image">
                    <img src="<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article" style="width:100%; max-width:800px; height:auto; margin:20px 0;">
                </div>
            <?php endif; ?>

            <article>
                <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
                <small>Publié le : <?= htmlspecialchars($article['dateCreation']) ?></small>
            </article>

            <a href="index.php" class="btn-custom">Retour aux actualités</a>

            <!-- Section des commentaires -->
            <div class="comments-section">
                <h3>Commentaires</h3>
                <?php if (isset($comments) && count($comments) > 0): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
                            <small>Par <strong><?= htmlspecialchars($comment['auteur']) ?></strong> le <?= htmlspecialchars($comment['dateCreation']) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun commentaire pour cet article.</p>
                <?php endif; ?>

                <form class="comment-form" method="POST" action="">
                    <label for="auteur">Votre nom :</label>
                    <input type="text" id="auteur" name="auteur" required>

                    <label for="commentaire">Votre commentaire :</label>
                    <textarea id="commentaire" name="commentaire" required></textarea>

                    <button type="submit">Envoyer</button>
                </form>
            </div>
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
