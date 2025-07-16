<?php

require_once 'config/config.php';
require_once 'Includes/functions.php';


if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

$success = '';
$error = '';


$roles = ['Manager', 'Employe', 'Gestionnaire', 'Commercial', 'Livreur', 'Directeur', 'Admin'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? '';

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if ($login === '' || $mot_de_passe === '' || $role === '') {
        $error = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!in_array($role, $roles)) {
        $error = "Rôle invalide.";
    } elseif (
        strlen($mot_de_passe) < 8 ||
        !preg_match('/[A-Z]/', $mot_de_passe) ||
        !preg_match('/[0-9]/', $mot_de_passe) ||
        strlen($mot_de_passe) > 25
    ) {
        $error = "Le mot de passe doit contenir entre 8 et 25 caractères avec au moins une majuscule et un chiffre.";
    } else {
        $stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE Email = ?");
        $stmt->execute([$login]);

        if ($stmt->fetch()) {
            $error = "Ce login est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateur (Email, motdepasse, fonction, nom, prenom, telephone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$login, $hash, $role, $nom, $prenom, $telephone]);
            $success = "Nouvel utilisateur créé avec succès.";
        }
    }
}


$utilisateurs = $pdo->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un utilisateur</title>
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
            <li><a href="suivi_commande.php">Suivi Commandes</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>


<div class="container">
    <h2>Créer un utilisateur</h2>

    <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?>


    <div class="flex-wrapper">
        <div class="form-section">
            <form method="POST" class="form-card">
                <label>Login *</label>
                <input type="text" name="login" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">

                <label>Mot de passe *</label>
                <input type="password" name="mot_de_passe" required>
                <small>Doit contenir au moins 8 caractères, une majuscule et un chiffre.</small>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <div style="flex: 1;">
                        <label>Nom</label>
                        <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                    </div>

                    <div style="flex: 1;">
                        <label>Prénom</label>
                        <input type="text" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                    </div>

                    <div style="flex: 1;">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                    </div>
                </div>

                <label>Rôle *</label>
                <select name="role" required>
                    <option value="">-- Sélectionner un rôle --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r ?>" <?= $r == ($_POST['role'] ?? '') ? 'selected' : '' ?>>
                            <?= ucfirst($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn">Créer l'utilisateur</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
