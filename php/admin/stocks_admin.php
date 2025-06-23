<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stocks - Fashion Chic</title>
  

  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap" rel="stylesheet">
  
  
  <link rel="stylesheet" href="../../assets/css/stocks_admin.css">

  
  <script defer src="../assets/js/stocks.js"></script>

  <style>
    body {
      font-family: 'Trocchi', serif;
    }

    .logo {
      width: 200px; /* plus grand */
    }

    .nav-links a {
      text-transform: capitalize;
    }

    .stock-table th {
      text-transform: capitalize;
    }

    .top-header h1 {
      text-transform: capitalize;
    }
  </style>
</head>
<body>

  <!-- menu latéral -->
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../assets/images/logo.svg" alt="Logo Fashion Chic" class="logo">
    </div>
    <nav class="nav-links">
      <a href="../dashboard.php">Dashboard</a>
      <a href="commandes.php">Commandes</a>
      <a href="factures.php">Factures</a>
      <a href="stocks.php" class="active">Stocks</a>
      <a href="creation_lots.php">Création de lots</a>
      <a href="profil.php">Profil</a>
      <a href="logout.php">Déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>Stocks disponibles - Admin</h1>
    </header>

    <section class="stock-table-section">
      <table class="stock-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Seuil d'alerte</th>
            <th>Catégorie</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $stocks = [
              ['nom' => 'Jupe', 'quantite' => 24, 'alerte' => 10, 'categorie' => 'Vêtements'],
              ['nom' => 'Robe', 'quantite' => 5, 'alerte' => 8, 'categorie' => 'Vêtements'],
              ['nom' => 'T-shirt', 'quantite' => 0, 'alerte' => 5, 'categorie' => 'Vêtements']
            ];

            foreach ($stocks as $stock) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($stock['nom']) . "</td>";
              echo "<td>" . $stock['quantite'] . "</td>";
              echo "<td>" . $stock['alerte'] . "</td>";
              echo "<td>" . htmlspecialchars($stock['categorie']) . "</td>";
              echo "<td><button class='btn-edit'>Modifier</button></td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
