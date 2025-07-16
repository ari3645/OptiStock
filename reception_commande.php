<?php
require_once 'config/config.php';
require_once 'Includes/functions.php';

if (!is_logged_in()) {
    header("Location: index.php");
    exit;
}

$success = null;
$error = null;


try {
    $stmt = $pdo->query("SELECT * FROM article ORDER BY Libelle_Article,         CASE taille
            WHEN 'XS' THEN 1
            WHEN 'S' THEN 2
            WHEN 'M' THEN 3
            WHEN 'L' THEN 4
            WHEN 'XL' THEN 5
            WHEN 'XXL' THEN 6
            ELSE 99
        END, Couleur  ASC");
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des articles : " . $e->getMessage();
    $articles = [];
}
try {
    $stmt = $pdo->query(" SELECT taille FROM (SELECT DISTINCT taille FROM article) AS tailles_uniques
    ORDER BY CASE taille
        WHEN 'XS' THEN 1
        WHEN 'S' THEN 2
        WHEN 'M' THEN 3
        WHEN 'L' THEN 4
        WHEN 'XL' THEN 5
        WHEN 'XXL' THEN 6
        ELSE 99
    END");
    $tailles = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $error = "Erreur lors du chargement des tailles : " . $e->getMessage();
    $tailles = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['Libelle_Article'] ?? '');
    $taille = $_POST['Taille'] ?? '';
    $couleur = trim($_POST['Couleur'] ?? '');
    $quantite_input = $_POST['Nb_Stock'] ?? null;
    $quantite = is_numeric($quantite_input) ? (int)$quantite_input : 0;

    if ($nom && $taille && $couleur && $quantite_input !== null && $quantite > 0) {
        try {
            $stmt = $pdo->prepare("SELECT Libelle_Article, Nb_Stock FROM article WHERE Libelle_Article = ? AND Taille = ? AND Couleur = ?");
            $stmt->execute([$nom, $taille, $couleur]);
            $article_existant = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article_existant) {
                $nouvelle_quantite = $article_existant['Nb_Stock'] + $quantite;
                $update = $pdo->prepare("UPDATE article SET Nb_Stock = ? WHERE Libelle_Article = ? AND Taille = ? AND Couleur = ?");
                $update->execute([$nouvelle_quantite, $nom, $taille, $couleur]);

                $success = "Quantité mise à jour avec succès.";
            } else {
                $insert = $pdo->prepare("INSERT INTO article (Libelle_Article, Taille, Couleur, Nb_Stock) VALUES (?, ?, ?, ?)");
                $insert->execute([$nom, $taille, $couleur, $quantite]);

                $success = "Article ajouté avec succès.";
            }

            header("Location: reception_commande.php");
            exit;

        } catch (PDOException $e) {
            $error = "Erreur lors du traitement : " . $e->getMessage();
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réception fournisseur</title>
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
            <li><a href="ajouter_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realisation_commande.php">Réaliser Commande</a></li>

            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Réception de vêtements fournisseur</h2>

    <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?>

    <div class="flex-global">
        <div class="left-section">
            <form method="POST" class="form-card">
                <label>Nom du vêtement :</label>
                <input type="text" name="Libelle_Article" required>

                <label>Taille :</label>
                <select name="Taille" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($tailles as $t): ?>
                        <option value="<?= $t ?>"><?= $t ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Couleur :</label>
                <input type="text" name="Couleur" required>

                <label>Quantité reçue :</label>
                <input type="number" name="Nb_Stock" min="1" required>

                <button type="submit" class="btn">Ajouter au stock</button>
            </form>
        </div>

        <div class="right-section">
            <h3>Articles en stock</h3>
            <?php if (empty($articles)): ?>
                <p>Aucun article actuellement en stock.</p>
            <?php else: ?>
                <table class="user-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Quantité</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= htmlspecialchars($article['Libelle_Article']) ?></td>
                            <td><?= htmlspecialchars($article['Taille']) ?></td>
                            <td><?= htmlspecialchars($article['Couleur']) ?></td>
                            <td><?= (int)$article['Nb_Stock'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
