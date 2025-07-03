<?php
require_once 'config/config.php';
require_once 'includes/functions.php';


$roles = ['Manager', 'Employe', 'Gestionnaire', 'Commercial', 'Livreur', 'Directeur', 'Admin'];
$email = $_GET['email'] ?? null;

if (!$email) {
    die("Email utilisateur non spécifié.");
}


$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE Email = ?");
$stmt->execute([$email]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    die("Utilisateur introuvable.");
}


$id = $utilisateur['ID_Utilisateur'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $role = $_POST['role'] ?? '';

    $stmt = $pdo->prepare("UPDATE utilisateur SET Email = ?, Nom = ?, Prenom = ?, Telephone = ?, Fonction = ? WHERE id_utilisateur = ?");
    $stmt->execute([$email, $nom, $prenom, $telephone, $role, $id]);

    header('Location: liste_utilisateurs.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Modifier l'utilisateur</h2>

    <form method="POST" class="form-card">
        <label>Email</label>
        <input type="text" name="email" required value="<?= htmlspecialchars($utilisateur['Email']) ?>">

        <label>Nom</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['Nom']) ?>">

        <label>Prénom</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['Prenom']) ?>">

        <label>Téléphone</label>
        <input type="text" name="telephone" value="<?= htmlspecialchars($utilisateur['Telephone']) ?>">

        <label>Rôle</label>
        <select name="role" required>
            <option value="">-- Sélectionner un rôle --</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r ?>" <?= $r == ($_POST['role'] ?? '') ? 'selected' : '' ?>>
                    <?= ucfirst($r) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn">Enregistrer les modifications</button>
    </form>
</div>

</body>
</html>