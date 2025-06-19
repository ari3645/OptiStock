<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';
$tailles = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage + standardisation
    $nom = ucfirst(strtolower(trim($_POST['nom'] ?? '')));
    $taille = strtoupper(trim($_POST['taille'] ?? ''));
    $couleur = ucfirst(strtolower(trim($_POST['couleur'] ?? '')));
    $quantite = (int)($_POST['quantite'] ?? 0);

    if ($nom === '' || $taille === '' || $couleur === '' || $quantite <= 0) {
        $error = "Veuillez remplir tous les champs obligatoires avec une quantité valide.";
    } else {
        // Requête pour vérifier si l'article existe déjà
        $stmt = $pdo->prepare("SELECT id, quantite FROM vetement WHERE nom = ? AND taille = ? AND couleur = ?");
        $stmt->execute([$nom, $taille, $couleur]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            $newQuantite = $article['quantite'] + $quantite;
            $stmt = $pdo->prepare("UPDATE vetement SET quantite = ? WHERE id = ?");
            $stmt->execute([$newQuantite, $article['id']]);
            $success = "Quantité mise à jour pour l'article existant.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO vetement (nom, taille, couleur, quantite) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $taille, $couleur, $quantite]);
            $success = "Nouvel article ajouté dans le stock.";
        }
    }
}

// Récupération des articles existants
$articles = $pdo->query("SELECT * FROM vetement ORDER BY nom, taille, couleur")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réception fournisseur</title>
    <style>
        table { border-collapse: collapse; margin-top: 30px; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
<h2>Réception de vêtements fournisseur</h2>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nom du vêtement :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Taille :</label><br>
    <select name="taille" required>
        <option value="">-- Sélectionner --</option>
        <?php foreach ($tailles as $t): ?>
            <option value="<?= $t ?>"><?= $t ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Couleur :</label><br>
    <input type="text" name="couleur" required><br><br>

    <label>Quantité reçue :</label><br>
    <input type="number" name="quantite" min="1" required><br><br>

    <button type="submit">Ajouter au stock</button>
</form>

<h3>Articles en stock</h3>

<?php if (empty($articles)): ?>
    <p>Aucun article actuellement en stock.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Taille</th>
            <th>Couleur</th>
            <th>Quantité</th>
            <th>Emplacement</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= htmlspecialchars($article['nom']) ?></td>
                <td><?= htmlspecialchars($article['taille']) ?></td>
                <td><?= htmlspecialchars($article['couleur']) ?></td>
                <td><?= (int)$article['quantite'] ?></td>
                <td><?= htmlspecialchars($article['emplacement'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
