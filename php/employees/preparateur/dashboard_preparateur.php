<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fashion Chic – Dashboard Préparateur</title>

  
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../../assets/css/dashboard_preparateur.css">
  
  <script defer src="../../../assets/js/dashboard_preparateur.js"></script>
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
      <h1>tableau de bord </h1>
    </header>

    <!-- quick-stats -->
    <section class="cards-container">
      <div class="stat-card" data-section="to-prepare">
        <p class="stat-title">à préparer</p>
        <p class="stat-value">5</p>
      </div>
      <div class="stat-card" data-section="ready">
        <p class="stat-title">prêtes</p>
        <p class="stat-value">8</p>
      </div>
    </section>

    <!-- zone dynamique par JS -->
    <section id="dynamic-content" class="content-section">
      <p>– choisis une carte pour voir les détails –</p>
    </section>
  </main>
</body>
</html>
