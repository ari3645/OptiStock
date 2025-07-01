<?php
// commandes_preparateur.php
// suivi des commandes + changement de statut (préparateur)

 // fausses données en attendant la BDD
$commandes = [
  ['id'=>1001,'produit'=>'Robe','quantite'=>2,'client'=>'Julie','statut'=>'en attente'],
  ['id'=>1002,'produit'=>'T-shirt','quantite'=>1,'client'=>'Sophie','statut'=>'prête à expédier'],
  ['id'=>1003,'produit'=>'Jupe','quantite'=>3,'client'=>'Marie','statut'=>'en attente'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Suivi commandes – préparateur</title>

  <!-- typo trocchi + fallback poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/commandes_preparateur.css">
  <script defer src="../../../assets/js/commandes_preparateur.js"></script>
</head>
<body>
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../../assets/images/logo.svg" alt="logo fashion chic" class="logo">
    </div>
    <nav class="nav-links">
      <a href="../preparateur/dashboard_preparateur.php">dashboard</a>
      <a href="../preparateur/commandes_suivi.php" class="active">suivi commandes</a>
      <a href="../preparateur/stocks_preparateur.php">visualisation stocks</a>
      <a href="../preparateur/creation_commandes_preparateur.php">création commande</a>
      <a href="logout.php">déconnexion</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="top-header">
      <h1>suivi des commandes</h1>
    </header>

    <section class="commandes-section">
      <table class="commandes-table">
        <thead>
          <tr>
            <th>n° commande</th>
            <th>produit</th>
            <th>quantité</th>
            <th>client</th>
            <th>statut</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($commandes as $c): ?>
          <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['produit']) ?></td>
            <td><?= $c['quantite'] ?></td>
            <td><?= htmlspecialchars($c['client']) ?></td>
            <td class="statut-cell"><?= htmlspecialchars($c['statut']) ?></td>
            <td>
              <button class="btn-change">changer statut</button>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
