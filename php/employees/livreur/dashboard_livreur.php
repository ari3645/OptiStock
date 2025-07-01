<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- meta obligatoires pour responsive -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fashion Chic - Dashboard Livreur</title>

  <!-- typo heading en trocchi, textes en poppins de secours -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css spécifique livreur (3 niveaux up) -->
  <link rel="stylesheet" href="../../../assets/css/dashboard_livreur.css">
  <!-- js dynamique -->
  <script defer src="../../../assets/js/dashboard_livreur.js"></script>
</head>
<body>
  <!-- sidebar fixe -->
  <aside class="sidebar">
    <div class="logo-container">
      <img src="../../../assets/images/logo.svg" alt="logo fashion chic" class="logo">
    </div>
    <nav class="nav-links">
      <!-- active sur la page courante -->
      <a href="dashboard_livreur.php" class="active">dashboard</a>
      <a href="commandes_livreur.php">commandes</a>
      <a href="logout.php">déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>tableau de bord livreur</h1>
    </header>

    <!-- quick-stats cards -->
    <section class="cards-container">
      <div class="stat-card" data-section="to-deliver">
        <p class="stat-title">à livrer</p>
        <p class="stat-value">3</p>
      </div>
      <div class="stat-card" data-section="delivered">
        <p class="stat-title">livrées</p>
        <p class="stat-value">7</p>
      </div>
    </section>

    <!-- zone mise à jour par js -->
    <section id="dynamic-content" class="content-section">
      <p>choisis une carte pour voir les commandes ici</p>
    </section>
  </main>
</body>
</html>
