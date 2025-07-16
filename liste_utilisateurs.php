<?php

require_once 'config/config.php';
require_once 'includes/functions.php';


if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

$utilisateurs = $pdo->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
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
            <li><a href="realiser_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php" class="active">Suivi Commandes</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Liste des Utilisateurs</h2>

    <table class="user-table">
    <thead>
    <tr>
        <th>Login</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Téléphone</th>
        <th>Rôle</th>
        <th>Action</th> <!-- Nouvelle colonne -->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $u): ?> 
        <tr>
            <td><?= htmlspecialchars($u['Email']) ?></td>
            <td><?= htmlspecialchars($u['Nom']) ?></td>
            <td><?= htmlspecialchars($u['Prenom']) ?></td>
            <td><?= htmlspecialchars($u['Telephone']) ?></td>
            <td><?= htmlspecialchars($u['Fonction']) ?></td>
            <td>
                <form method="GET" action="modifier_utilisateur.php">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($u['Email'] ?? '') ?>">
                    <button type="submit" class="table-btn"">Modifier</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

</body>
</html>