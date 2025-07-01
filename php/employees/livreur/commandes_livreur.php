<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Commandes à livrer – Fashion Chic (Livreur)</title>

  <!-- typo trocchi + fallback poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- même CSS que pour les pages commandes des autres rôles -->
  <link rel="stylesheet" href="../../../assets/css/commandes_admin.css" />
  <script defer src="../../../assets/js/commandes_livreur.js"></script>


  <style>
    
    body { font-family: 'Trocchi', serif; }
    
    .top-header h1,
    .commandes-table th,
    .commandes-table td,
    .nav-links a {
      text-transform: capitalize;
    }
    /* logo quickfix */
    .logo { width: 200px; }
  </style>

  <script defer src="../../assets/js/commandes_livreur.js"></script>

</head>
<body>

  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../../assets/images/logo.svg" alt="Logo Fashion Chic" class="logo">
    </div>
    <nav class="nav-links">
            <a href="../livreur/dashboard_livreur.php">Dashboard</a>
      <a href="commandes_livreur.php" class="active">Statuts Commandes</a>

      <a href="../logout.php">Déconnexion</a>
    </nav>
  </aside>


  <main class="main-content">
    <header class="top-header">
      <h1>Statuts Commandes</h1>
    </header>

    <section class="commandes-section">
      <table class="commandes-table">
        <thead>
          <tr>
            <th>N° commande</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Client</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <?php
            // données fictives pour le livreur
            $commandes = [
              ['id'=>1001,'produit'=>'Robe','quantite'=>2,'client'=>'Julie','statut'=>'prête'],
              ['id'=>1002,'produit'=>'T-shirt','quantite'=>1,'client'=>'Sophie','statut'=>'prête'],
            ];
            foreach($commandes as $cmd){
              echo "<tr>";
              echo "<td>{$cmd['id']}</td>";
              echo "<td>".htmlspecialchars($cmd['produit'])."</td>";
              echo "<td>{$cmd['quantite']}</td>";
              echo "<td>".htmlspecialchars($cmd['client'])."</td>";
              echo "<td>".htmlspecialchars($cmd['statut'])."</td>";
              echo "<td><button class='btn-status'>Marquer livré</button></td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
