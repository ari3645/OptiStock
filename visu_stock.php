<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visualisation des stocks</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .rupture { color: red; font-weight: bold; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
            <img src="images/logo.png" alt="Logo OptiStock" class="navbar-logo-img">
            <a href="index.php" class="navbar-logo">OptiStock</a>
        </div>
        <ul class="navbar-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="ajout_employe.php">Ajouter Employé</a></li>
            <li><a href="ajouter_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realisation_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_fournisseur.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commandes.php">Suivi Commandes</a></li>
            <li><a href="visualisation_stocks.php" class="active">Stocks</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Stocks dans l'entrepôt</h2>

    <!-- Formulaire de recherche -->
    <form method="GET" class="form-card search-form" style="margin-bottom: 20px;">
        <input type="text" name="recherche" placeholder="Recherche globale" class="search-input">
        <button type="submit" class="btn search-button">Rechercher</button>
    </form>

    <!-- Vêtements -->
    <h3>Vêtements individuels</h3>
    <table class="user-table">
        <tr>
            <th>Nom</th>
            <th>Taille</th>
            <th>Couleur</th>
            <th>Quantité</th>
            <th>Emplacement</th>
        </tr>
        <!-- <?php foreach ($vetements as $vetement): ?>
            <tr>
                <td><?= htmlspecialchars($vetement['nom']) ?></td>
                <td><?= $vetement['taille'] ?></td>
                <td><?= $vetement['couleur'] ?></td>
                <td class="<?= $vetement['quantite'] == 0 ? 'rupture' : '' ?>">
                    <?= $vetement['quantite'] == 0 ? 'Rupture de stock' : $vetement['quantite'] ?>
                </td>
                <td><?= htmlspecialchars($vetement['emplacement'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?> -->
    </table>

    <!-- Lots -->
    <h3>Lots créés</h3>
    <table class="user-table">
        <tr>
            <th>Nom du lot</th>
            <th>Unités par lot</th>
            <th>Quantité (lots)</th>
            <th>Emplacement</th>
        </tr>
        <!-- <?php if (empty($lots)): ?>
            <tr><td colspan="4">Aucun lot enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($lots as $lot): ?>
                <tr>
                    <td><?= htmlspecialchars($lot['nom']) ?></td>
                    <td><?= (int)$lot['unites_par_lot'] ?></td>
                    <td><?= (int)$lot['quantite'] ?></td>
                    <td><?= htmlspecialchars($lot['emplacement']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?> -->
    </table>

    <br>
    <a href="dashboard.php" class="btn-secondary" style="display: inline-block;">⬅ Retour au tableau de bord</a>
</div>

</body>
</html>
