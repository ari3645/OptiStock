<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fashion Chic - Tableau de bord Admin</title>


  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap" rel="stylesheet">

  
<link rel="stylesheet" href="../../assets/css/dashboard_admin.css">


  
<script src="../../assets/js/dashboard_admin.js"></script>

  <style>
    body {
      font-family: 'Trocchi', serif;
    }

    .logo {
      width: 200px;
    }

    .nav-links a,
    .stat-title,
    .stat-value,
    .top-header h1,
    #dynamic-content p {
      text-transform: capitalize;
    }
  </style>
</head>
<body>

  <!-- menu latéral -->
  <aside class="sidebar">
   <div class="logo-container">

  <img
    src="../../assets/images/logo.svg"
    alt="Logo Fashion Chic"
    class="logo"
  >
</div>

    <nav class="nav-links">
      <a href="dashboard_admin.php" class="active">Dashboard</a>
      <a href="commandes_admin.php">Commandes</a>
      <a href="factures_admin.php">Factures</a>
      <a href="stocks_admin.php">Stocks</a>
      <a href="creation_lots_admin.php">Création de lots</a>
      <a href="profil_admin.php">Profil</a>
      <a href="logout.php">Déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>Tableau de bord - Admin</h1>

      <div class="search-bar">
        <input type="text" placeholder="Recherche...">
      </div>
    </header>

    <section class="cards-container">
      <div class="stat-card" data-section="commandes">
        <p class="stat-title">Commandes</p>
        <p class="stat-value">132</p>
      </div>
      <div class="stat-card" data-section="factures">
        <p class="stat-title">Factures</p>
        <p class="stat-value">48</p>
      </div>
      <div class="stat-card" data-section="stocks">
        <p class="stat-title">Stocks</p>
        <p class="stat-value">78</p>
      </div>
      <div class="stat-card" data-section="lots">
        <p class="stat-title">Lots</p>
        <p class="stat-value">15</p>
      </div>
    </section>

    <section id="dynamic-content" class="content-section">
      <p>Sélectionne une carte pour voir les infos ici.</p>
    </section>
  </main>

</body>
</html>
