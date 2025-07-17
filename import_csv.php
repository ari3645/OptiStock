<?php
require_once 'config/config.php';

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    die("Erreur de chargement du fichier CSV.");
}

$handle = fopen($_FILES['csv_file']['tmp_name'], 'r');
if (!$handle) {
    die("Impossible d’ouvrir le fichier CSV.");
}

fgetcsv($handle);

$inserted = 0;
$updated = 0;
$skipped = 0;

while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
    list(
        $Article_ID, $Libelle_Article, $Numero_Article, $Taille, $Couleur,
        $Modele_Article, $Nb_Stock, $Emplacement_ID, $purchase_price, $sales_price
        ) = $data;

    $Nb_Stock = (int) str_replace(',', '.', $Nb_Stock);
    $purchase_price = (float) str_replace(',', '.', $purchase_price);
    $sales_price = (float) str_replace(',', '.', $sales_price);

    if (!is_numeric($Nb_Stock) || !is_numeric($purchase_price) || !is_numeric($sales_price)) {
        echo "⚠️ Ligne ignorée : données numériques invalides pour $Numero_Article<br>";
        $skipped++;
        continue;
    }

    $checkStmt = $pdo->prepare("SELECT Nb_Stock FROM article WHERE Numero_Article = ?");
    $checkStmt->execute([$Numero_Article]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $newStock = $existing['Nb_Stock'] + $Nb_Stock;

        $updateStmt = $pdo->prepare("
            UPDATE article SET 
                Libelle_Article = ?, Taille = ?, Couleur = ?, Modele_Article = ?, 
                Nb_Stock = ?, Emplacement_ID = ?, purchase_price = ?, sales_price = ?
            WHERE Numero_Article = ?
        ");
        $updateStmt->execute([
            $Libelle_Article, $Taille, $Couleur, $Modele_Article,
            $newStock, $Emplacement_ID, $purchase_price, $sales_price,
            $Numero_Article
        ]);
        $updated++;
    } else {
        $insertStmt = $pdo->prepare("
            INSERT INTO article (
                Libelle_Article, Numero_Article, Taille, Couleur, Modele_Article,
                Nb_Stock, Emplacement_ID, purchase_price, sales_price
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $insertStmt->execute([
            $Libelle_Article, $Numero_Article, $Taille, $Couleur, $Modele_Article,
            $Nb_Stock, $Emplacement_ID, $purchase_price, $sales_price
        ]);
        $inserted++;
    }
}

fclose($handle);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Import terminé</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>✅ Import terminé</h2>
    <ul>
        <li>📥 Nouveaux articles insérés : <strong><?= $inserted ?></strong></li>
        <li>🔁 Articles mis à jour (stock additionné) : <strong><?= $updated ?></strong></li>
        <li>⛔ Lignes ignorées : <strong><?= $skipped ?></strong></li>
    </ul>
    <a href="visu_stock.php" class="btn">⬅ Retour</a>
</div>
</body>
</html>
