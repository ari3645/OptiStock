<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';

$roles = ['manager', 'employe', 'gestionnaire', 'commercial'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? '';
    $id_reference = (int)($_POST['id_reference'] ?? 0);

    if ($login === '' || $mot_de_passe === '' || $role === '' || $id_reference === 0) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!in_array($role, $roles)) {
        $error = "Rôle invalide.";
    } elseif (
        strlen($mot_de_passe) < 8 ||
        !preg_match('/[A-Z]/', $mot_de_passe) ||
        !preg_match('/[0-9]/', $mot_de_passe)
    ) {
        $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $error = "Ce login est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateur (login, mot_de_passe, role, id_reference) VALUES (?, ?, ?, ?)");
            $stmt->execute([$login, $hash, $role, $id_reference]);
            $success = "Nouvel utilisateur créé avec succès.";
        }
    }
}

$utilisateurs = $pdo->query("SELECT * FROM utilisateur ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">MonSite</a>
        <ul class="navbar-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="ajout_employe.php" class="active">Ajouter Employé</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container">
    <h2>Créer un utilisateur</h2>

    <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="form-card">
        <label>Login *</label>
        <input type="text" name="login" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">

        <label>Mot de passe *</label>
        <input type="password" name="mot_de_passe" required>
        <small>Doit contenir au moins 8 caractères, une majuscule et un chiffre.</small>

        <label>Rôle *</label>
        <select name="role" required>
            <option value="">-- Sélectionner un rôle --</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r ?>" <?= $r == ($_POST['role'] ?? '') ? 'selected' : '' ?>>
                    <?= ucfirst($r) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>ID de référence *</label>
        <input type="number" name="id_reference" min="1" required value="<?= htmlspecialchars($_POST['id_reference'] ?? '') ?>">

        <button type="submit" class="btn">Créer l'utilisateur</button>
    </form>

    <h3>Utilisateurs existants</h3>
    <table class="user-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Rôle</th>
            <th>ID Référence</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($utilisateurs as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= htmlspecialchars($u['role']) ?></td>
                <td><?= htmlspecialchars($u['id_reference']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
