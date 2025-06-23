<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Commandes - Fashion Chic</title>

  
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="../../assets/css/commandes_admin.css" />


  <script defer src="../../assets/js/commandes_admin.js"></script>
</head>
<body style="font-family: 'Trocchi', serif;">

  <!-- menu latéral -->
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../assets/images/logo.svg" alt="logo fashion chic" class="logo">
    </div>
    <nav class="nav-links">
        <a href="../dashboard.php">Dashboard</a>
      <a href="commandes.php" class="active">Commandes</a>
      <a href="factures.php">Factures</a>
      <a href="stocks.php">Stocks</a>
      <a href="creation_lots.php">Création de lots</a>
      <a href="profil.php">Profil</a>
      <a href="logout.php">Déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>Commandes en cours</h1>
    </header>

    <!-- tableau des commandes -->
    <section class="commandes-section">
      <table class="commandes-table">
        <thead>
          <tr>
            <th>N° Commande</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Client</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // données fictives pour l’instant
            $commandes = [
              ['id' => 1001, 'produit' => 'robe', 'quantite' => 2, 'client' => 'Julie', 'statut' => 'en attente'],
              ['id' => 1002, 'produit' => 't-shirt', 'quantite' => 1, 'client' => 'Sophie', 'statut' => 'expédiée'],
              ['id' => 1003, 'produit' => 'jupe', 'quantite' => 3, 'client' => 'Marie', 'statut' => 'en attente']
            ];

            foreach ($commandes as $cmd) {
              echo "<tr>";
              echo "<td>" . $cmd['id'] . "</td>";
              echo "<td>" . htmlspecialchars($cmd['produit']) . "</td>";
              echo "<td>" . $cmd['quantite'] . "</td>";
              echo "<td>" . htmlspecialchars($cmd['client']) . "</td>";
              echo "<td>" . htmlspecialchars($cmd['statut']) . "</td>";
              echo "<td><button class='btn-status'>Changer</button></td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </section>

    <!-- zone de détail dynamique -->
    <section id="order-detail" class="content-section">
      <p>Sélectionne une commande pour afficher ses détails ici.</p>
    </section>
  </main>

</body>
</html>
