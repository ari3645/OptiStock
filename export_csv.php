<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=articles_export.csv');

$output = fopen('php://output', 'w');

fputcsv($output, [
    'Article_ID', 'Libelle_Article', 'Numero_Article',
    'Taille', 'Couleur', 'Modele_Article',
    'Nb_Stock', 'Emplacement_ID', 'purchase_price', 'sales_price'
]);

$sql = "SELECT * FROM article";
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;
