<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réception fournisseur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
            <img src="images/logo.svg" alt="Logo OptiStock" class="navbar-logo-img">
            <a href="index.php" class="navbar-logo">OptiStock</a>
        </div>
        <ul class="navbar-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="ajout_employe.php">Ajouter Employé</a></li>
            <li><a href="ajouter_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realisation_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_fournisseur.php" class="active">Réception Fournisseur</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Réception de vêtements fournisseur</h2>

    <!-- <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?> -->

    <div class="flex-global">
        <!-- Formulaire à gauche -->
        <div class="left-section">
            <form method="POST" class="form-card">
                <label>Nom du vêtement :</label>
                <input type="text" name="nom" required>

                <label>Taille :</label>
                <select name="taille" required>
                    <option value="">-- Sélectionner --</option>
                    <!-- <?php foreach ($tailles as $t): ?>
                        <option value="<?= $t ?>"><?= $t ?></option>
                    <?php endforeach; ?> -->
                </select>

                <label>Couleur :</label>
                <input type="text" name="couleur" required>

                <label>Quantité reçue :</label>
                <input type="number" name="quantite" min="1" required>

                <button type="submit" class="btn">Ajouter au stock</button>
            </form>
        </div>

        <!-- Stock à droite -->
        <div class="right-section">
            <h3>Articles en stock</h3>
<!-- 
            <?php if (empty($articles)): ?>
                <p>Aucun article actuellement en stock.</p>
            <?php else: ?> -->
                <table class="user-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Quantité</th>
                        <th>Emplacement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= htmlspecialchars($article['nom']) ?></td>
                            <td><?= htmlspecialchars($article['taille']) ?></td>
                            <td><?= htmlspecialchars($article['couleur']) ?></td>
                            <td><?= (int)$article['quantite'] ?></td>
                            <td><?= htmlspecialchars($article['emplacement'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?> -->
                    </tbody>
                </table>
            <!-- <?php endif; ?> -->
        </div>
    </div>
</div>
</body>
</html>
