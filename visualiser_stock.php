<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$mot_cle = $_GET['recherche'] ?? '';

// Recherche des vêtements
if ($mot_cle) {
    $stmt = $pdo->prepare("
        SELECT id, nom, taille, couleur, quantite, emplacement
        FROM vetement
        WHERE nom LIKE :mc OR taille LIKE :mc OR couleur LIKE :mc OR emplacement LIKE :mc
    ");
    $stmt->execute(['mc' => '%' . $mot_cle . '%']);
} else {
    $stmt = $pdo->query("SELECT id, nom, taille, couleur, quantite, emplacement FROM vetement");
}
$vetements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des lots avec unités par lot
$lots = $pdo->query("
    SELECT l.id, l.nom, l.emplacement, l.quantite,
           SUM(lv.quantite) AS unites_par_lot
    FROM lot l
    LEFT JOIN lot_vetement lv ON lv.lot_id = l.id
    GROUP BY l.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visualisation des stocks</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .rupture { color: red; font-weight: bold; }
    </style>
</head>
<body>
<h2>Stocks dans l'entrepôt</h2>

<!-- Formulaire de recherche -->
<form method="GET">
    <input type="text" name="recherche" placeholder="Recherche globale" value="<?= htmlspecialchars($mot_cle) ?>">
    <button type="submit">Rechercher</button>
</form>

<!-- Vêtements -->
<h3>Vêtements individuels</h3>
<table>
    <tr>
        <th>Nom</th>
        <th>Taille</th>
        <th>Couleur</th>
        <th>Quantité</th>
        <th>Emplacement</th>
    </tr>
    <?php foreach ($vetements as $vetement): ?>
        <tr>
            <td><?= htmlspecialchars($vetement['nom']) ?></td>
            <td><?= $vetement['taille'] ?></td>
            <td><?= $vetement['couleur'] ?></td>
            <td class="<?= $vetement['quantite'] == 0 ? 'rupture' : '' ?>">
                <?= $vetement['quantite'] == 0 ? 'Rupture de stock' : $vetement['quantite'] ?>
            </td>
            <td><?= htmlspecialchars($vetement['emplacement'] ?? '-') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Lots -->
<h3>Lots créés</h3>
<table>
    <tr>
        <th>Nom du lot</th>
        <th>Unités par lot</th>
        <th>Quantité (lots)</th>
        <th>Emplacement</th>
    </tr>
    <?php if (empty($lots)): ?>
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
    <?php endif; ?>
</table>

<br>
<a href="dashboard.php">⬅ Retour au tableau de bord</a>
</body>
</html>
