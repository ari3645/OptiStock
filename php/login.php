<?php
// login.php
// (ton futur traitement PHP viendra ici)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Fashion Chic – Connexion</title>

  <!-- typo principales -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/login.css">
  <script defer src="../assets/js/login.js"></script>
</head>
<body>

  <div class="login-page">
    <div class="hero">
      <img src="../assets/images/login-hero.svg" alt="Décor abstrait" class="hero-img">
      <h2>Bienvenue à Fashion Chic</h2>
      <p>Connectez-vous pour accéder à vos fonctionnalités.</p>
    </div>

    <div class="form-side">
      <img src="../assets/images/logo.svg" alt="Logo Fashion Chic" class="logo">
      <h1>Connexion</h1>
      <form id="loginForm" method="POST" action="login.php">
        <div class="field">
          <label for="username">Identifiant</label>
          <input type="text" id="username" name="username" required>
          <p class="error" id="err-username"></p>
        </div>
        <div class="field">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required>
          <p class="error" id="err-password"></p>
        </div>
        <div class="links">
          <button type="button" class="link-btn" id="forgot-user">Identifiant oublié ?</button>
          <button type="button" class="link-btn" id="forgot-pass">Mot de passe oublié ?</button>
        </div>
        <button type="submit" class="btn-login">Se connecter</button>
      </form>
      <p class="help">Besoin d’aide ? <a href="#">Centre d’aide</a></p>
    </div>
  </div>

</body>
</html>
