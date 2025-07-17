<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

    $recherche = isset($_GET['recherche']) ? trim($_GET['recherche']) : '';

    // --- VÊTEMENTS ---
    if (!empty($recherche)) {
        $sql = "SELECT 
                    Libelle_Article,
                    Taille,
                    Couleur,
                    Nb_Stock,
                    Emplacement_ID
                FROM article
                WHERE 
                    Libelle_Article LIKE :rech1
                    OR Taille LIKE :rech2
                    OR Couleur LIKE :rech3
                    OR Emplacement_ID LIKE :rech4";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'rech1' => '%' . $recherche . '%',
            'rech2' => '%' . $recherche . '%',
            'rech3' => '%' . $recherche . '%',
            'rech4' => '%' . $recherche . '%',
        ]);
    } else {
        $sql = "SELECT 
                    Libelle_Article,
                    Taille,
                    Couleur,
                    Nb_Stock,
                    Emplacement_ID
                FROM article";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    $vetements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- LOTS ---
    if (!empty($recherche)) {
        $sqlLots = "SELECT Modele_Lot, Quantite_Article 
                    FROM lot 
                    WHERE 
                        Modele_Lot LIKE :rech1";
        $stmtLots = $pdo->prepare($sqlLots);
        $stmtLots->execute([
            'rech1' => '%' . $recherche . '%',
        ]);
    } else {
        $sqlLots = "SELECT Modele_Lot, Quantite_Article FROM lot";
        $stmtLots = $pdo->prepare($sqlLots);
        $stmtLots->execute();
    }
    $lots = $stmtLots->fetchAll(PDO::FETCH_ASSOC);

?>

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
            <li><a href="creer_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realiser_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php">Suivi Commandes</a></li>
            <li><a href="visu_stock.php" class="active">Stocks</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<h3>Exports / Imports du stock</h3>

<!-- Export -->
<form method="POST" action="export_csv.php" style="display:inline;">
    <button type="submit" class="btn">📤 Exporter CSV</button>
</form>
</br>

<!-- Import -->
<form method="POST" action="import_csv.php" enctype="multipart/form-data" style="display:inline; margin-left:10px;">
    <input type="file" name="csv_file" accept=".csv" required>
    <button type="submit" class="btn">📥 Importer CSV</button>
</form>

<div class="container">
    <h2>Stocks dans l'entrepôt</h2>

    <!-- Formulaire de recherche -->
    <form method="GET" class="form-card search-form" style="margin-bottom: 20px;">
        <input type="text" name="recherche" placeholder="Recherche globale" class="search-input" value="<?= htmlspecialchars($recherche ?? '') ?>">
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
        <?php if (empty($vetements)): ?>
            <tr><td colspan="5">Aucun vêtement trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($vetements as $vetement): ?>
                <tr>
                    <td><?= htmlspecialchars($vetement['Libelle_Article']) ?></td>
                    <td><?= htmlspecialchars($vetement['Taille']) ?></td>
                    <td><?= htmlspecialchars($vetement['Couleur']) ?></td>
                    <td class="<?= $vetement['Nb_Stock'] == 0 ? 'rupture' : '' ?>">
                        <?= $vetement['Nb_Stock'] == 0 ? 'Rupture de stock' : htmlspecialchars($vetement['Nb_Stock']) ?>
                    </td>
                    <td><?= htmlspecialchars($vetement['Emplacement_ID'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <!-- Lots -->
    <h3>Lots créés</h3>
    <table class="user-table">
        <tr>
            <th>Nom du lot</th>
            <th>Unités par lot</th>
        </tr>
        <?php if (empty($lots)): ?>
            <tr><td colspan="2">Aucun lot trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($lots as $lot): ?>
                <tr>
                    <td><?= htmlspecialchars($lot['Modele_Lot']) ?></td>
                    <td><?= (int)$lot['Quantite_Article'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <br>
    <a href="dashboard.php" class="btn-secondary" style="display: inline-block;">⬅ Retour au tableau de bord</a>
</div>

</body>
</html>
