<?php
// on inclut la config PDO (connexion à la BDD)
// et on traite le POST si besoin

/*
require_once __DIR__ . '/../config.php';


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
*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion Utilisateurs – Admin</title>
  <link rel="stylesheet" href="../../assets/css/gestion_users.css">
  <script defer src="../../assets/js/gestion_users.js"></script>
</head>
<body>
  <!-- sidebar commune -->
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../assets/images/logo.svg" alt="Logo Fashion Chic" class="logo">
    </div>
    <nav class="nav-links">
      <a href="../admin/dashboard_admin.php">Dashboard</a>
      <a href="../admin/commandes_admin.php">Commandes</a>
      <a href="../admin/factures_admin.php" class="active">Factures</a>
      <a href="../admin/stocks_admin.php">Stocks</a>
      <a href="../admin/creation_lots_admin.php">Création de lots</a>
      <a href="../logout.php">Déconnexion</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="top-header">
      <h1>Gestion des utilisateurs</h1>
    </header>

    <section class="form-section">
      <form id="user-form" class="user-form">
        <h2>Créer un nouvel utilisateur</h2>
        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
          <label for="fonction">Fonction</label>
          <select id="fonction" name="fonction" required>
            <option value="">-- Choisissez --</option>
            <option value="admin">Admin</option>
            <option value="gestionnaire">Gestionnaire</option>
            <option value="commercial">Commercial</option>
            <option value="preparateur">Préparateur</option>
            <option value="livreur">Livreur</option>
          </select>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="telephone">Téléphone</label>
          <input type="tel" id="telephone" name="telephone">
        </div>
        <div class="form-group">
          <label for="motdepasse">Mot de passe</label>
          <input type="password" id="motdepasse" name="motdepasse" required>
        </div>
        <button type="submit" class="btn primary">Créer</button>
        <p id="response-msg" class="response-msg"></p>
      </form>
    </section>

    <!-- section liste des users (exemple statique) -->
    <section class="users-list-section">
      <h2>Liste des utilisateurs</h2>
      <table class="users-table">
        <thead>
          <tr><th>Nom</th><th>Prénom</th><th>Fonction</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <!-- pr boucler sur SELECT * FROM Utilisateur -->
          <tr>
            <td>Dupont</td><td>Marie</td><td>commercial</td><td>m.dupont@mail.com</td>
            <td><button class="btn-edit-user">✏️</button>
                <button class="btn-del-user">🗑️</button></td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
