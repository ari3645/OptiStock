<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Commandes - Fashion Chic (Gestionaire)</title>

  <!-- typo trocchi + fallback poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- on réutilise le CSS/JS “admin” car même layout -->
  <link rel="stylesheet" href="../../assets/css/commandes_admin.css" />
  <script defer src="../../assets/js/commandes_admin.js"></script>

  <style>

    body { font-family: 'Trocchi', serif; }
    .nav-links a,
    .top-header h1,
    .commandes-table th,
    .commandes-table td,
    #order-detail p {
      text-transform: capitalize;
    }
  </style>
</head>
<body>


  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../assets/images/logo.svg" alt="Logo Fashion Chic" class="logo">
    </div>
    <nav class="nav-links">
      <a href="dashboard_gestionaire.php">Dashboard</a>
      <a href="commandes_gestionaire.php" class="active">Commandes</a>
      <a href="factures_gestionaire.php">Factures</a>
      <a href="stocks_gestionaire.php">Stocks</a>
      <a href="creation_lots_gestionaire.php">Création de lots</a>
      
      <a href="../logout.php">Déconnexion</a>
    </nav>
  </aside>


  <main class="main-content">
    <header class="top-header">
      <h1>Commandes en cours</h1>
    </header>

    <!-- tableau des commandes -->
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
          <?php
            // données fictives pour l’instant
            $commandes = [
              ['id' => 1001, 'produit' => 'robe', 'quantite' => 2, 'client' => 'Julie', 'statut' => 'en attente'],
              ['id' => 1002, 'produit' => 't-shirt', 'quantite' => 1, 'client' => 'Sophie', 'statut' => 'expédiée'],
              ['id' => 1003, 'produit' => 'jupe', 'quantite' => 3, 'client' => 'Marie', 'statut' => 'en attente']
            ];
            foreach ($commandes as $cmd) {
              echo "<tr>";
              echo "<td>{$cmd['id']}</td>";
              echo "<td>".htmlspecialchars($cmd['produit'])."</td>";
              echo "<td>{$cmd['quantite']}</td>";
              echo "<td>".htmlspecialchars($cmd['client'])."</td>";
              echo "<td>".htmlspecialchars($cmd['statut'])."</td>";
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
