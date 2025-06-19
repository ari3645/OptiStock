<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$statuts = $pdo->query("SELECT * FROM statut")->fetchAll(PDO::FETCH_ASSOC);
$statut_en_attente = array_filter($statuts, fn($s) => strtolower($s['nom']) === 'en attente');
$id_en_attente = reset($statut_en_attente)['id'] ?? 0;

$cmds_attente = $pdo->prepare("SELECT c.id, c.nom AS cmd_nom, cl.nom AS client_nom
    FROM commande c
    JOIN client cl ON c.client_id = cl.id
    WHERE c.statut_id = ?");
$cmds_attente->execute([$id_en_attente]);
$attentes = $cmds_attente->fetchAll(PDO::FETCH_ASSOC);

$selected_cmd = $_POST['select_commande'] ?? null;
$cocher = $_POST['cocher'] ?? [];
$cmd = null;
$error = '';

if ($selected_cmd) {
    $cmd = (int)$selected_cmd;

    // Passage à "en cours"
    $pdo->prepare("UPDATE commande SET statut_id = (SELECT id FROM statut WHERE nom = 'en cours') WHERE id = ?")
        ->execute([$cmd]);

    // Sauvegarde des éléments cochés
    if (!empty($cocher)) {
        foreach ($cocher as $commande_lot_id) {
            $check = $pdo->prepare("SELECT id FROM pickings WHERE commande_id = ? AND commande_lot_id = ?");
            $check->execute([$cmd, $commande_lot_id]);

            if (!$check->fetch()) {
                $insert = $pdo->prepare("INSERT INTO pickings (commande_id, commande_lot_id) VALUES (?, ?)");
                $insert->execute([$cmd, $commande_lot_id]);
            }
        }
    }

    // Traitement du bouton "Marquer comme prête"
    if (isset($_POST['complete_cmd'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande_lot WHERE commande_id = ?");
        $stmt->execute([$cmd]);
        $nb_total = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(DISTINCT commande_lot_id) FROM pickings WHERE commande_id = ?");
        $stmt->execute([$cmd]);
        $nb_fait = $stmt->fetchColumn();

        if ($nb_total == $nb_fait) {
            $pdo->prepare("UPDATE commande SET statut_id = (SELECT id FROM statut WHERE nom = 'prete') WHERE id = ?")
                ->execute([$cmd]);
            header("Location: realisation_commande.php");
            exit;
        } else {
            $error = "Tous les éléments ne sont pas encore cochés.";
        }
    }
}

$lots = [];
$pickings = [];

if ($cmd) {
    $stmt = $pdo->prepare("
        SELECT cl.id AS commande_lot_id, l.nom, cl.quantite
        FROM commande_lot cl
        JOIN lot l ON cl.lot_id = l.id
        WHERE cl.commande_id = ?
    ");
    $stmt->execute([$cmd]);
    $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT commande_lot_id FROM pickings WHERE commande_id = ?");
    $stmt->execute([$cmd]);
    $pickings = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'commande_lot_id');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réalisation de commande</title>
</head>
<body>
<h2>Réalisation de commande</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Commandes en attente :</label><br>
    <select name="select_commande" onchange="this.form.submit()">
        <option value="">-- Sélectionner une commande --</option>
        <?php foreach ($attentes as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $cmd) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['cmd_nom']) ?> (<?= htmlspecialchars($c['client_nom']) ?>)
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($cmd): ?>
    <h3>Commande n°<?= $cmd ?></h3>
    <form method="POST">
        <input type="hidden" name="select_commande" value="<?= $cmd ?>">

        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
            <tr>
                <th>Article / Lot</th>
                <th>Quantité</th>
                <th>Fait ?</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lots as $l): ?>
                <tr>
                    <td><?= htmlspecialchars($l['nom']) ?></td>
                    <td><?= (int)$l['quantite'] ?></td>
                    <td>
                        <input type="checkbox" name="cocher[]" value="<?= $l['commande_lot_id'] ?>"
                            <?= in_array($l['commande_lot_id'], $pickings) ? 'checked' : '' ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <button type="submit" name="save_progress">Sauvegarder</button>
        <button type="submit" name="complete_cmd">Marquer comme prête</button>
    </form>
<?php endif; ?>
</body>
</html>
