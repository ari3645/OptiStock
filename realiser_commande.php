<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

$error = '';
$cmd = $_POST['select_commande'] ?? $_GET['select_commande'] ?? null;
$pickings = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_progress']) && $cmd) {
        $stmt = $pdo->prepare("DELETE FROM commande_lot_pick WHERE commande_lot_id IN (
                                SELECT commande_lot_id FROM commande_lot WHERE commande_id = :id)");
        $stmt->execute(['id' => $cmd]);

        if (!empty($_POST['cocher'])) {
            $stmtInsert = $pdo->prepare("INSERT INTO commande_lot_pick (commande_lot_id, realise) VALUES (:id, 1)");
            foreach ($_POST['cocher'] as $lot_id) {
                $stmtInsert->execute(['id' => $lot_id]);
            }
        }
    }

    if (isset($_POST['complete_cmd']) && $cmd) {

        $stmt = $pdo->prepare("UPDATE commande SET statut = 'Validée' WHERE Commande_ID = :id");
        $stmt->execute(['id' => $cmd]);

        header("Location: realiser_commande.php");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT Commande_ID, Numero_Commande, Client_ID FROM commande WHERE statut = 'En attente'");
$stmt->execute();
$attentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lots = [];
if ($cmd) {
    $stmt = $pdo->prepare("UPDATE commande SET statut = 'Confirmée' WHERE Commande_ID = :id AND statut = 'En attente'");
    $stmt->execute(['id' => $cmd]);
    $stmt = $pdo->prepare("SELECT Lot_ID, Quantite_Lot FROM commande WHERE Commande_ID = :id");
    $stmt->execute(['id' => $cmd]);
    $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réalisation de commande</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

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
            <li><a href="realiser_commande.php" class="active">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php">Suivi Commandes</a></li>
            <li><a href="visu_stock.php">Stocks</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Réalisation de commande</h2>

    <?php if ($error): ?>
        <p class="message-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="form-card">
        <label>Commandes en attente :</label>
        <select name="select_commande" onchange="this.form.submit()">
            <option value="">-- Sélectionner une commande --</option>
            <?php foreach ($attentes as $c): ?>
                <option value="<?= $c['Commande_ID'] ?>" <?= ($c['Commande_ID'] == $cmd) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['Numero_Commande']) ?> (<?= htmlspecialchars($c['Client_ID']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($cmd): ?>
        <h3>Commande n° <?= $cmd ?></h3>
        <form method="POST" class="form-card">
            <input type="hidden" name="select_commande" value="<?= $cmd ?>">

            <table class="user-table">
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
                        <td><?= htmlspecialchars($l['Lot_ID']) ?></td>
                        <td><?= (int)$l['Quantite_Lot'] ?></td>
                        <td>
                            <input type="checkbox" name="cocher[]" value="<?= $l['Lot_ID'] ?>"
                                <?= in_array($l['Lot_ID'], $pickings) ? 'checked' : '' ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="button-group" style="margin-top: 15px;">
                <button type="submit" name="complete_cmd" class="btn-secondary">Marquer comme prête</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
