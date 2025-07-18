<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réalisation de commande</title>
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
            <li><a href="realisation_commande.php" class="active">Réaliser Commande</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Réalisation de commande</h2>

    <!-- <?php if ($error): ?>
        <p class="message-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?> -->

    <!-- Formulaire de sélection de commande -->
    <form method="POST" class="form-card">
        <label>Commandes en attente :</label>
        <select name="select_commande" onchange="this.form.submit()">
            <option value="">-- Sélectionner une commande --</option>
            <!-- <?php foreach ($attentes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $cmd) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['cmd_nom']) ?> (<?= htmlspecialchars($c['client_nom']) ?>)
                </option>
            <?php endforeach; ?> -->
        </select>
    </form>

    <!-- <?php if ($cmd): ?> -->
        <h3>Commande n°1
            <!-- <?= $cmd ?> -->
        </h3>
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
                <!-- <?php foreach ($lots as $l): ?>
                    <tr>
                        <td><?= htmlspecialchars($l['nom']) ?></td>
                        <td><?= (int)$l['quantite'] ?></td>
                        <td>
                            <input type="checkbox" name="cocher[]" value="<?= $l['commande_lot_id'] ?>"
                                <?= in_array($l['commande_lot_id'], $pickings) ? 'checked' : '' ?>>
                        </td>
                    </tr>
                <?php endforeach; ?> -->
                </tbody>
            </table>

            <div class="button-group" style="margin-top: 15px;">
                <button type="submit" name="save_progress" class="btn">Sauvegarder</button>
                <button type="submit" name="complete_cmd" class="btn-secondary">Marquer comme prête</button>
            </div>
        </form>
    <!-- <?php endif; ?> -->
</div>

</body>
</html>
