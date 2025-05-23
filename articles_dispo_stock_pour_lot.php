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
            af.ID_Fournisseur,
            f.Nom_Fournisseur,
            af.Pttx_fournisseur
        FROM Article a
        LEFT JOIN Article_Fournisseur af ON a.Article_ID = af.Article_ID
        LEFT JOIN Fournisseur f ON af.ID_Fournisseur = f.ID_Fournisseur
        WHERE a.Nb_Stock > 0
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $articles = $stmt->fetchAll();

    foreach ($articles as $article) {
        echo "<div style='margin-bottom:1em;'>";
        echo "👕 <strong>" . htmlspecialchars($article['Libelle_Article']) . "</strong><br>";
        echo "🔢 Numéro : " . htmlspecialchars($article['Numero_Article']) . "<br>";
        echo "📏 Taille : " . htmlspecialchars($article['Taille']) . "<br>";
        echo "🎨 Couleur : " . htmlspecialchars($article['Couleur']) . "<br>";
        echo "📦 Stock : " . (int)$article['Nb_Stock'] . "<br>";
        echo "🏷️ Fournisseur : " . htmlspecialchars($article['Nom_Fournisseur'] ?? 'Non défini') . "<br>";
        echo "</div>";
    }

} catch (PDOException $e) {
    echo "❌ Erreur : " . htmlspecialchars($e->getMessage());
}
?>