<?php
// stocks_preparateur.php
// page stocks en lecture seule pour le preparateur

// fausse bdd en attendant la vraie
$stocks = [
  ['nom'=>'Jupe','quantite'=>24,'alerte'=>10,'categorie'=>'Vêtements'],
  ['nom'=>'Robe','quantite'=>5,'alerte'=>8,'categorie'=>'Vêtements'],
  ['nom'=>'T-shirt','quantite'=>0,'alerte'=>5,'categorie'=>'Vêtements']
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Stocks – préparateur</title>

  <
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/stocks_preparateur.css">
  <script defer src="../../../assets/js/stocks_preparateur.js"></script>
</head>
<body>
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../../assets/images/logo.svg" alt="logo fashion chic" class="logo">
    </div>
    <nav class="nav-links">
      <a href="../preparateur/dashboard_preparateur.php" class="active">dashboard</a>
      <a href="../preparateur/commandes_suivi.php">suivi commandes</a>
      <a href="../preparateur/stocks_preparateur.php">visualisation stocks</a>
      <a href="../preparateur/creation_commandes_preparateur.php">création commande</a>
      <a href="logout.php">déconnexion</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="top-header">
      <h1>stocks disponibles</h1>
      <div class="search-bar">
        <input type="text" id="filter-input" placeholder="filtrer par produit…">
      </div>
    </header>

    <section class="stock-table-section">
      <table class="stock-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Seuil d'alerte</th>
            <th>Catégorie</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($stocks as $s): ?>
          <tr>
            <td><?= htmlspecialchars($s['nom']) ?></td>
            <td><?= $s['quantite'] ?></td>
            <td><?= $s['alerte'] ?></td>
            <td><?= htmlspecialchars($s['categorie']) ?></td>
          </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
