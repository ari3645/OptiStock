<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Création de lots - Fashion Chic (Gestionaire)</title>
  <!-- typo trocchi + fallback poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- same CSS/JS que pour l’admin -->
  <link rel="stylesheet" href="../../assets/css/creation_lots.css">
  <script defer src="../../assets/js/creation_lots.js"></script>
  <style>
    body { font-family: 'Trocchi', serif; }
    .nav-links a,
    .top-header h1,
    .lot-form-section h2,
    .available-section h2,
    .lot-preview-section h2 {
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
      <a href="commandes_gestionaire.php">Commandes</a>
      <a href="factures_gestionaire.php">Factures</a>
      <a href="stocks_gestionaire.php">Stocks</a>
      <a href="creation_lots_gestionaire.php" class="active">Création de lots</a>
      <a href="../logout.php">Déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>Création / gestion de lots</h1>
    </header>

    <!-- formulaire lot -->
    <section class="lot-form-section">
      <h2>🆕 Nouveau lot</h2>
      <div class="form-group">
        <label for="lot-name">Nom du lot</label>
        <input type="text" id="lot-name" placeholder="Ex : Lot été 2025">
      </div>
    </section>

    <div class="lists-container">

      <!-- colonne articles dispo -->
      <section class="available-section">
        <h2>Articles en stock</h2>
        <div class="available-list">


          <?php
            // ton script PHP/commenté ici
            // require_once 'articles_dispo_stock_pour_lot.php';
            // mock pour test :
            $mock = [
              ['Libelle'=>'Robe longue','Numero'=>'A101','Taille'=>'M','Couleur'=>'Rouge','Nb_Stock'=>12,'Fournisseur'=>'ChezNous'],
              ['Libelle'=>'T-shirt basique','Numero'=>'B202','Taille'=>'L','Couleur'=>'Blanc','Nb_Stock'=>30,'Fournisseur'=>'VetementsPlus']
            ];
            foreach($mock as $art){
              echo "<div class='article-card'>
                      <p><strong>{$art['Libelle']}</strong> ({$art['Taille']}, {$art['Couleur']})</p>
                      <p>Stock : {$art['Nb_Stock']}</p>
                      <button data-libelle=\"{$art['Libelle']}\" data-max=\"{$art['Nb_Stock']}\" class='btn-add'>Ajouter</button>
                    </div>";
            }
          ?>
        </div>
      </section>

      <!-- colonne lot en cours -->
      <section class="lot-preview-section">
        <h2>Aperçu du lot</h2>
        <table class="lot-table">
          <thead>
            <tr>
              <th>Article</th>
              <th>Quantité</th>
              <th>Suppr.</th>
            </tr>
          </thead>
          <tbody>
            <!-- JS injecte les lignes ici -->
          </tbody>
        </table>
        <button id="create-lot" class="btn-primary">Créer le lot</button>
        <p id="response-msg" class="response-msg"></p>
      </section>
    </div>

  </main>
</body>
</html>
