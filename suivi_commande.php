<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

// Récupération des statuts
$statuts = $pdo->query("SELECT * FROM statut")->fetchAll(PDO::FETCH_ASSOC);

// Gestion du filtre
$filtre_statut = isset($_GET['statut']) ? (int)$_GET['statut'] : 0;

// Mise à jour du statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commande_id'], $_POST['statut_id'])) {
    $commande_id = (int)$_POST['commande_id'];
    $nouveau_statut = (int)$_POST['statut_id'];
    $stmt = $pdo->prepare("UPDATE commande SET statut_id = ? WHERE id = ?");
    $stmt->execute([$nouveau_statut, $commande_id]);
}

// Requête principale
$query = "
    SELECT c.id, c.nom AS commande_nom, s.id AS statut_id, s.nom AS statut_nom, cl.nom AS client_nom, cl.adresse
    FROM commande c
    JOIN statut s ON c.statut_id = s.id
    JOIN client cl ON c.client_id = cl.id
";

$params = [];
if ($filtre_statut > 0) {
    $query .= " WHERE s.id = ?";
    $params[] = $filtre_statut;
}
$query .= " ORDER BY c.id ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Classes CSS pour badges
function badge_class($statut) {
    return match (strtolower($statut)) {
        'en attente' => 'badge-grey',
        'en cours' => 'badge-orange',
        'prete' => 'badge-green',
        'livrée' => 'badge-blue',
        default => 'badge-default',
    };
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des commandes</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }

        .badge-grey { background-color: #888; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-orange { background-color: orange; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-green { background-color: green; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-blue { background-color: royalblue; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-default { background-color: #ccc; color: black; padding: 4px 8px; border-radius: 4px; }

        form.inline { display: inline; margin: 0; }
    </style>
</head>
<body>

<h2>Suivi des commandes</h2>

<!-- Filtre par statut -->
<form method="get">
    <label>Filtrer par statut :</label>
    <select name="statut" onchange="this.form.submit()">
        <option value="0">-- Tous les statuts --</option>
        <?php foreach ($statuts as $statut): ?>
            <option value="<?= $statut['id'] ?>" <?= ($statut['id'] == $filtre_statut ? 'selected' : '') ?>>
                <?= htmlspecialchars($statut['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Tableau -->
<table>
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
                <td><?= nl2br(htmlspecialchars($commande['adresse'])) ?></td>
                <td>
                        <span class="<?= badge_class($commande['statut_nom']) ?>">
                            <?= htmlspecialchars($commande['statut_nom']) ?>
                        </span>
                </td>
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                        <select name="statut_id">
                            <?php foreach ($statuts as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= ($s['id'] == $commande['statut_id'] ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($s['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">🆗</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
