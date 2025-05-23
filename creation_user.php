<?php
require_once 'config.php'; 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécuriser les entrées
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $fonction = trim($_POST['fonction']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO Utilisateur (Nom, Prenom, Fonction, Email, Telephone, MotDePasse)
                VALUES (:nom, :prenom, :fonction, :email, :telephone, :motdepasse)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':fonction', $fonction);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':motdepasse', $motdepasse);

        $stmt->execute();
        echo "✅ Utilisateur créé avec succès.";
    } catch (PDOException $e) {
        echo "❌ Erreur : " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "⚠️ Méthode non autorisée.";
}