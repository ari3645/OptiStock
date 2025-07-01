<!DOCTYPE html>
<html lang="fr">
<head>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenue chez Fashion Chic</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Don't forget to change the fonts-->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> 
</head>
<body>

  <!--  Barre de navigation fixe, prone to change -->
  <header class="navbar">
    <div class="logo">Fashion Chic</div>
    <nav>
      <ul>
        <li><a href="#features">Fonctionnalités</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="php/login.php" class="btn-nav">Connexion</a></li>
      </ul>
    </nav>
  </header>

  <!--  Section Héro : doux comme une landing de startup -->
  <section class="hero">
    <h1>Optimisez vos stocks avec style 💄📦</h1>
    <p>Une solution douce mais sérieuse pour gérer commandes, stocks et factures.</p>
    <a href="login.html" class="btn primary">Commencer maintenant</a>
  </section>

  <!--  main fct -->
  <section id="features" class="features">
    <h2>Ce que vous pouvez faire avec VDRM</h2>
    <div class="grid">
      <div class="feature-card">🧾 Visualiser et créer des factures</div>
      <div class="feature-card">📦 Gérer et recevoir les stocks</div>
      <div class="feature-card">🧺 Créer des lots d’articles divers </div>
      <div class="feature-card">📊 Filtrer, modifier et suivre les commandes</div>
      <div class="feature-card">💼 Interface unique et personnalisée </div>
      <div class="feature-card">🧠 Tableau de bord intelligent</div>
    </div>
  </section>


  <footer id="contact" class="footer">
    <p>Besoin d’aide ? Contactez-nous à <a href="mailto:support@vdrm.com">support@vdrm.com</a></p>
  </footer>

  <!-- potentiel PHP -->

  <?php
    // Exemple d'inclusion de logique PHP
    // include("backend/connect.php");
    // include("backend/session_check.php");
  ?>

</body>
</html>
