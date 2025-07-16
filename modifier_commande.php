<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

$commande_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Charger les infos de la commande
$stmt = $pdo->prepare("SELECT * FROM commande WHERE Commande_ID = ?");
$stmt->execute([$commande_id]);
$commande = $stmt->fetch();

if (!$commande) {
    die("Commande non trouvée.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupérer les anciennes valeurs AVANT la suppression
    $stmt_old = $pdo->prepare("SELECT dt_creation, dt_validation, date_expedition, date_expedition_prevue, livreur, retard, commande_retard, categorie_retard FROM commande WHERE Commande_ID = ?");
    $stmt_old->execute([$commande_id]);
    $ancienne_commande = $stmt_old->fetch(PDO::FETCH_ASSOC);

    // 2. Supprimer les anciennes lignes liées à cette commande
    $pdo->prepare("DELETE FROM commande WHERE Commande_ID = ?")->execute([$commande_id]);

    $lots = $_POST['lot_id'] ?? [];
    $quantites = $_POST['quantite'] ?? [];

    foreach ($lots as $index => $lot_id) {
        $quantite = intval($quantites[$index]);

        if ($quantite > 0) {
            $stmt = $pdo->prepare("SELECT Prix_Lot FROM lot WHERE Lot_ID = ?");
            $stmt->execute([$lot_id]);
            $prix_lot = $stmt->fetchColumn();

            if ($prix_lot !== false) {
                // 3. Insérer les nouvelles lignes avec les anciennes valeurs si présentes
                $pdo->prepare("
                    INSERT INTO commande (
                        Numero_Commande, Id_Createur_Commande, Client_ID, Lot_ID, Quantite_Lot, Prix_Total_Commande, Statut,
                        dt_creation, dt_validation, date_expedition, date_expedition_prevue, livreur, retard, commande_retard, categorie_retard
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?,
                            ?, ?, ?, ?, ?, ?, ?, ?)
                ")->execute([
                    $commande['Numero_Commande'],
                    $commande['Id_Createur_Commande'],
                    $commande['Client_ID'],
                    $lot_id,
                    $quantite,
                    $prix_lot * $quantite,
                    $commande['Statut'],

                    // Valeurs conservées ou null
                    $ancienne_commande['dt_creation'] ?? null,
                    $ancienne_commande['dt_validation'] ?? null,
                    $ancienne_commande['date_expedition'] ?? null,
                    $ancienne_commande['date_expedition_prevue'] ?? null,
                    $ancienne_commande['livreur'] ?? null,
                    $ancienne_commande['retard'] ?? null,
                    $ancienne_commande['commande_retard'] ?? null,
                    $ancienne_commande['categorie_retard'] ?? null,
                ]);
            }
        }
    }

    header("Location: suivi_commande.php?modification=ok");
    exit;
}

// === Récupérer les lots déjà présents dans la commande ===
$lots_commande = $pdo->prepare("
    SELECT c.Lot_ID, c.Quantite_Lot AS Quantite, l.Numero_Lot
    FROM commande c
    JOIN lot l ON c.Lot_ID = l.Lot_ID
    WHERE c.Commande_ID = ?
");
$lots_commande->execute([$commande_id]);
$lots_actuels = $lots_commande->fetchAll();

// === Récupérer tous les autres lots disponibles non inclus dans la commande ===
$lots_ids_inclus = array_column($lots_actuels, 'Lot_ID');
$placeholders = implode(',', array_fill(0, count($lots_ids_inclus), '?'));

if (count($lots_ids_inclus) > 0) {
    $stmt = $pdo->prepare("SELECT Lot_ID, Numero_Lot FROM lot WHERE Lot_ID NOT IN ($placeholders)");
    $stmt->execute($lots_ids_inclus);
} else {
    $stmt = $pdo->query("SELECT Lot_ID, Numero_Lot FROM lot");
}
$lots_non_inclus = $stmt->fetchAll();
?>

<h2>Modifier la commande</h2>
<link rel="stylesheet" href="css/style.css">

<form method="post">
    <h3>Lots actuellement dans la commande</h3>
    <div class="lots-centres">
        <table>
            <tr>
                <th>Lot</th>
                <th>Quantité</th>
            </tr>
            <?php foreach ($lots_actuels as $lot): ?>
                <tr>
                    <td><?= htmlspecialchars($lot['Numero_Lot']) ?></td>
                    <td>
                        <input type="number" name="quantite[]" value="<?= (int)$lot['Quantite'] ?>" min="1">
                        <input type="hidden" name="lot_id[]" value="<?= $lot['Lot_ID'] ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php if (!empty($lots_non_inclus)): ?>
        <h3>Ajouter un ou plusieurs lots</h3>
        <div class="lots-grille">
            <?php foreach ($lots_non_inclus as $lot): ?>
                <div class="lot-item">
                    <strong><?= htmlspecialchars($lot['Numero_Lot']) ?></strong><br>
                    <input type="number" name="quantite[]" min="0" value="0"><br>
                    <input type="hidden" name="lot_id[]" value="<?= $lot['Lot_ID'] ?>">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br>
    <button type="submit">💾 Enregistrer les modifications</button>
</form>
