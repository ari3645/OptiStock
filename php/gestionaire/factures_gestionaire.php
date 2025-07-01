<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Factures - Fashion Chic (Gestionaire)</title>
  <!-- typo trocchi + fallback poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <!--  same CSS/JS  -->
  <link rel="stylesheet" href="../../assets/css/factures.css">
  <script defer src="../../assets/js/factures.js"></script>
  <style>
    
    body { font-family: 'Trocchi', serif; }
   
    .nav-links a,
    .top-header h1,
    .invoices-table th,
    .invoices-table td,
    .invoice-detail td {
      text-transform: capitalize;
    }
    /* logo quickfix */
    .logo { width: 200px; }
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
      <a href="factures_gestionaire.php" class="active">Factures</a>
      <a href="stocks_gestionaire.php">Stocks</a>
      <a href="creation_lots_gestionaire.php">Création de lots</a>
      <a href="../logout.php">Déconnexion</a>
    </nav>
  </aside>

  <!-- contenu principal -->
  <main class="main-content">
    <header class="top-header">
      <h1>Visualisation des factures</h1>
    </header>

    <section class="invoices-section">
      <table class="invoices-table">
        <thead>
          <tr>
            <th>n° facture</th>
            <th>commande</th>
            <th>montant</th>
            <th>date</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // données fictives en attendant la BDD
            $invoices = [
              ['id'=>2001,'commande'=>1001,'montant'=>49.90,'date'=>'2025-06-12'],
              ['id'=>2002,'commande'=>1002,'montant'=>25.00,'date'=>'2025-06-10'],
              ['id'=>2003,'commande'=>1003,'montant'=>99.90,'date'=>'2025-06-08']
            ];
            foreach($invoices as $inv){
              echo "<tr>";
              echo "<td>{$inv['id']}</td>";
              echo "<td>{$inv['commande']}</td>";
              echo "<td>".number_format($inv['montant'],2,',','.')." €</td>";
              echo "<td>{$inv['date']}</td>";
              echo "<td><button class='btn-detail'>Détails</button></td>";
              echo "</tr>";
              // ligne de détail cachée
              echo "<tr class='invoice-detail'><td colspan='5'>Contenu de la facture #{$inv['id']}… (détail mocké)</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
