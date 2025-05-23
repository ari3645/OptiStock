<?php
require_once 'config.php'; 

try {
    $sql = "
        SELECT 
            a.Article_ID,
            a.Libelle_Article,
            a.Numero_Article,
            a.Taille,
            a.Couleur,
            a.Modele_Article,
            a.Nb_Stock,
            e.Zone AS Zone_Entrepot,
            e.Rangee,
            e.Etagere
        FROM Article a
        LEFT JOIN Emplacement e ON a.Emplacement_ID = e.ID_Emplacement
        WHERE a.Nb_Stock > 0
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll();

    foreach ($resultats as $article) {
        echo "<div style='margin-bottom:1em; padding: 10px; border: 1px solid #ccc;'>";
        echo "<strong>🧾 " . htmlspecialchars($article['Libelle_Article']) . "</strong><br>";
        echo "🔢 Numéro : " . htmlspecialchars($article['Numero_Article']) . "<br>";
        echo "📦 Stock : " . (int)$article['Nb_Stock'] . "<br>";
        echo "🎨 Couleur : " . htmlspecialchars($article['Couleur']) . "<br>";
        echo "📏 Taille : " . htmlspecialchars($article['Taille']) . "<br>";
        echo "📍 Emplacement : Zone " . htmlspecialchars($article['Zone_Entrepot'] ?? 'N/A') .
             " - Rangée " . htmlspecialchars($article['Rangee'] ?? '-') .
             " - Étagère " . htmlspecialchars($article['Etagere'] ?? '-') . "<br>";
        echo "</div>";
    }

} catch (PDOException $e) {
    echo "❌ Erreur : " . htmlspecialchars($e->getMessage());
}
?>