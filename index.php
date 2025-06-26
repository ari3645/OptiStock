<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des commandes</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Badges de statut */
        .badge-grey { background-color: #888; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-orange { background-color: orange; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-green { background-color: green; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-blue { background-color: royalblue; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-default { background-color: #ccc; color: black; padding: 4px 8px; border-radius: 4px; }

        form.inline { display: inline; margin: 0; }
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
            <li><a href="suivi_commandes.php" class="active">Suivi Commandes</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Suivi des commandes</h2>

    <!-- Filtre par statut -->
    <form method="get" class="form-card search-form" style="margin-bottom: 20px;">
        <label>Filtrer par statut :</label>
        <select name="statut" onchange="this.form.submit()">
            <option value="0">-- Tous les statuts --</option>
            <!-- <?php foreach ($statuts as $statut): ?>
                <option value="<?= $statut['id'] ?>" <?= ($statut['id'] == $filtre_statut ? 'selected' : '') ?>>
                    <?= htmlspecialchars($statut['nom']) ?>
                </option>
            <?php endforeach; ?> -->
        </select>
    </form>

    <!-- Tableau des commandes -->
    <table class="user-table">
        <thead>
        <tr>
            <th>Nom commande</th>
            <th>Client</th>
            <th>Adresse</th>
            <th>Statut</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <!-- <?php if (empty($commandes)): ?>
            <tr><td colspan="5">Aucune commande trouvée.</td></tr>
        <?php else: ?>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= htmlspecialchars($commande['commande_nom']) ?></td>
                    <td><?= htmlspecialchars($commande['client_nom']) ?></td>
                    <td><?= nl2br(htmlspecialchars($commande['adresse'])) ?></td> -->
                    <td>
                        <!-- <span class="A_mettre">
                            <?= htmlspecialchars($commande['statut_nom']) ?>
                        </span> -->
                    </td>
                    <td>
                        <form method="post" class="inline">
                            <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                            <select name="statut_id">
                                <!-- <?php foreach ($statuts as $s): ?>
                                    <option value="<?= $s['id'] ?>" <?= ($s['id'] == $commande['statut_id'] ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($s['nom']) ?>
                                    </option>
                                <?php endforeach; ?> -->
                            </select>
                            <button type="submit" class="btn">🆗</button>
                        </form>
                    </td>
                </tr>
            <!-- <?php endforeach; ?>
        <?php endif; ?> -->
        </tbody>
    </table>
</div>

</body>
</html>
