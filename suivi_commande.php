<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

$commandes = [];
$filtre_statut = $_GET['statut'] ?? '';

try {
    $stmt = $pdo->query("SELECT DISTINCT Statut AS nom FROM commande");
    $statuts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($statuts as $index => $s) {
        $statuts[$index]['id'] = $s['nom'];
    }
} catch (PDOException $e) {
    echo "Erreur lors du chargement des statuts : " . $e->getMessage();
    $statuts = [];
}

try {
    if (!empty($filtre_statut)) {
        $stmt = $pdo->prepare("
            SELECT 
                c.Commande_ID, 
                c.Numero_Commande AS commande_nom, 
                cl.Nom_Client AS client_nom, 
                cl.Adresse AS Adresse, 
                c.Statut AS statut_nom
            FROM commande c
            LEFT JOIN client cl ON c.Client_ID = cl.Client_ID
            WHERE c.Statut = :statut
        ");
        $stmt->execute(['statut' => $filtre_statut]);
    } else {
        $stmt = $pdo->query("
            SELECT 
                c.Commande_ID, 
                c.Numero_Commande AS commande_nom, 
                cl.Nom_Client AS client_nom, 
                cl.Adresse AS Adresse, 
                c.Statut AS statut_nom
            FROM commande c
            LEFT JOIN client cl ON c.Client_ID = cl.Client_ID
        ");
    }
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors du chargement des commandes : " . $e->getMessage();
    $commandes = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des commandes</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
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
            <li><a href="creer_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realiser_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php" class="active">Suivi Commandes</a></li>
            <li><a href="visu_stock.php">Stocks</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Suivi des commandes</h2>

    <form method="get" style="margin-bottom: 20px;">
        <label>Filtrer par statut :</label>
        <select name="statut" onchange="this.form.submit()">
            <option value="0">-- Tous les statuts --</option>
            <?php foreach ($statuts as $statut): ?>
                <option value="<?= $statut['nom'] ?>" <?= ($statut['nom'] == $filtre_statut ? 'selected' : '') ?>>
                    <?= htmlspecialchars($statut['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

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
        <?php if (empty($commandes)): ?>
            <tr><td colspan="5">Aucune commande trouvée.</td></tr>
        <?php else: ?>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= htmlspecialchars($commande['commande_nom']) ?></td>
                    <td><?= htmlspecialchars($commande['client_nom']) ?></td>
                    <td><?= htmlspecialchars($commande['Adresse'] ?? '-') ?></td>
                    <td>
                        <span class="<?//= badge_class($commande['statut_nom']) ?>">
                            <?= htmlspecialchars($commande['statut_nom']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="modifier_commande.php?id=<?= $commande['Commande_ID'] ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
