<?php

// faux stock et liste de clients en attendant la BDD
$stock = [
  ['id'=>1,'nom'=>'Jupe','dispo'=>24],
  ['id'=>2,'nom'=>'Robe','dispo'=>5],
  ['id'=>3,'nom'=>'T-shirt','dispo'=>30],
];
$clients = ['Julie','Sophie','Marie','Paul'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Création commande – préparateur</title>


  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/creation_commandes_preparateur.css">
  <script defer src="../../../assets/js/creation_commandes_preparateur.js"></script>
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
      <h1>création Commandes</h1>
    </header>

    <section class="form-section">
      <form id="order-form">
        <div class="form-group">
          <label for="client-select">client</label>
          <select id="client-select" required>
            <option value="">choisir un client</option>
            <?php foreach($clients as $c): ?>
              <option><?= htmlspecialchars($c) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="product-select">produit</label>
          <select id="product-select" required>
            <option value="">choisir un produit</option>
            <?php foreach($stock as $p): ?>
              <option value="<?= $p['id'] ?>" data-dispo="<?= $p['dispo'] ?>">
                <?= htmlspecialchars($p['nom']) ?> (dispo: <?= $p['dispo'] ?>)
              </option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="quantity-input">quantité</label>
          <input type="number" id="quantity-input" min="1" placeholder="ex : 1" required>
          <small id="qty-error" class="error-msg"></small>
        </div>
        <button type="submit" class="btn-primary">ajouter à la liste</button>
      </form>
    </section>

    <section class="preview-section">
      <h2>aperçu des commandes</h2>
      <table class="orders-table">
        <thead>
          <tr>
            <th>client</th>
            <th>produit</th>
            <th>quantité</th>
            <th>supprimer</th>
          </tr>
        </thead>
        <tbody>
          <!-- lignes générées en js -->
        </tbody>
      </table>
      <button id="submit-orders" class="btn-primary">valider toutes les commandes</button>
      <p id="submit-msg" class="response-msg"></p>
    </section>
  </main>
</body>
</html>
