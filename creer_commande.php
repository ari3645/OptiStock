<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

 // Initialisation
 if (!isset($_SESSION['commande_en_cours'])) {
     $_SESSION['commande_en_cours'] = [];
 }

 $clients = $pdo->query("SELECT * FROM client ORDER BY Nom_Client ASC")->fetchAll(PDO::FETCH_ASSOC);

 $nom_commande = trim($_POST['nom_commande'] ?? '');
 $client_id = (int)($_POST['client_id'] ?? 0);
 $adresse_client = '';
 $success = '';
 $error = '';

 if ($client_id) {
     $stmt = $pdo->prepare("SELECT adresse FROM client WHERE id = ?");
     $stmt->execute([$client_id]);
     $adresse_client = $stmt->fetchColumn();
 }

 // Ajouter un lot
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'ajouter_lot') {
     $lot_id = (int)($_POST['lot_id'] ?? 0);
     $quantite = (int)($_POST['quantite'] ?? 0);

     $stmt = $pdo->prepare("SELECT Quantite_Article FROM lot WHERE Lot_ID = ?");
     $stmt->execute([$lot_id]);
     $dispo = $stmt->fetchColumn();

     if ($dispo !== false && $quantite > 0 && $quantite <= $dispo) {
         $_SESSION['commande_en_cours'][$lot_id] = ($_SESSION['commande_en_cours'][$lot_id] ?? 0) + $quantite;
     }
 }

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'vider_commande') {
     $_SESSION['commande_en_cours'] = [];
 }

 if (isset($_GET['retirer'])) {
     unset($_SESSION['commande_en_cours'][(int)$_GET['retirer']]);
     header("Location: creer_commande.php");
     exit;
 }

 if (isset($_GET['vider'])) {
     $_SESSION['commande_en_cours'] = [];
     header("Location: creer_commande.php");
     exit;
 }

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'creer_commande') {
     if ($nom_commande === '' || $client_id === 0) {
         $error = "Nom de commande et client obligatoires.";
     } elseif (empty($_SESSION['commande_en_cours'])) {
         $error = "Aucun lot sélectionné.";
     } else {
         $erreur_stock = false;

         foreach ($_SESSION['commande_en_cours'] as $lot_id => $qte) {
             $stmt = $pdo->prepare("SELECT quantite FROM lot WHERE id = ?");
             $stmt->execute([$lot_id]);
             $stock = $stmt->fetchColumn();
             if ($stock < $qte) {
                 $error = "Stock insuffisant pour le lot ID $lot_id.";
                 $erreur_stock = true;
                 break;
             }
         }

         if (!$erreur_stock) {
             $stmt = $pdo->prepare("INSERT INTO commande (nom, date_creation, statut_id, client_id) VALUES (?, NOW(), 1, ?)");
             $stmt->execute([$nom_commande, $client_id]);
             $commande_id = $pdo->lastInsertId();

             foreach ($_SESSION['commande_en_cours'] as $lot_id => $qte) {
                 $stmt = $pdo->prepare("INSERT INTO commande_lot (commande_id, lot_id, quantite) VALUES (?, ?, ?)");
                 $stmt->execute([$commande_id, $lot_id, $qte]);

                 $stmt = $pdo->prepare("UPDATE lot SET quantite = quantite - ? WHERE id = ?");
                 $stmt->execute([$qte, $lot_id]);
             }

             $_SESSION['commande_en_cours'] = [];

             $stmt = $pdo->prepare("SELECT nom FROM client WHERE id = ?");
             $stmt->execute([$client_id]);
             $nom_client = $stmt->fetchColumn();

             $success = "Commande \"<strong>" . htmlspecialchars($nom_commande) . "</strong>\" pour le client <strong>" . htmlspecialchars($nom_client) . "</strong> créée avec succès.";
             $nom_commande = '';
             $client_id = 0;
             $adresse_client = '';
         }
     }
 }

 $lots_disponibles = $pdo->query("SELECT * FROM lot WHERE Quantite_Article > 0")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une commande</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
            <img src="images/logo.png" alt="Logo OptiStock" class="navbar-logo-img">
            <a href="index.php" class="navbar-logo">OptiStock</a>
        </div>
        <ul class="navbar-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="ajout_employe.php">Ajouter Employé</a></li>
            <li><a href="creer_lot.php">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realiser_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php" class="active">Suivi Commandes</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Créer une nouvelle commande</h2>

    <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?>

    <div class="flex-global">
        <!-- Colonne gauche : Création de la commande -->
        <div class="left-section">
            <form method="POST" class="form-card">
                <label>Nom de la commande :</label>
                <input type="text" name="nom_commande" required >

                <label>Client :</label>
                <select name="client_id" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['Client_ID'] ?>" <?= ($client['Client_ID'] == $client_id ? 'selected' : '') ?>>
                            <?= htmlspecialchars($client['Nom_Client']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($adresse_client): ?>
                    <p><strong>Adresse :</strong> <?= nl2br(htmlspecialchars($adresse_client)) ?></p>
                <?php endif; ?>

                <div class="button-group" style="margin-top: 15px;">
                    <button type="submit" name="action" value="creer_commande" class="btn">Créer la commande</button>
                    <button type="submit" name="action" value="vider_commande" class="btn-secondary" onclick="return confirm('Vider la commande en cours ?');">Vider</button>
                </div>
            </form>
        </div>

        <!-- Colonne droite : Deux tableaux côte à côte -->
        <div class="right-section">
            <div class="flex-tables">
                <!-- Lots disponibles -->
                <div class="lots-section">
                    <h3>Lots disponibles</h3>
                    <?php foreach ($lots_disponibles as $lot): ?>
                        <?php
                        $dispo = $lot['Quantite_Article'];
                        $dejajoutee = $_SESSION['commande_en_cours'][$lot['Lot_ID']] ?? 0;
                        $restant = $dispo - $dejajoutee;
                        ?>
                        <?php if ($restant > 0): ?>
                            <form method="POST" class="form-card" style="margin-bottom: 10px;">
                                <p><?= htmlspecialchars($lot['Modele_Lot']) ?> (Stock: <?= $restant ?>)</p>
                                <input type="number" name="quantite" min="1" max="<?= $restant ?>" value="1" required>
                                <input type="hidden" name="lot_id" value="<?= $lot['ID_Article'] ?>">
                                <button type="submit" name="action" value="ajouter_lot" class="btn">Ajouter</button>
                            </form>
                        <?php else: ?>
                            <p><?= htmlspecialchars($lot['nom']) ?> → <span style="color:red;">Rupture</span></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Commande en cours -->
                <div class="commande-section">
                    <h3>Commande en cours</h3>
                    <?php if (empty($_SESSION['commande_en_cours'])): ?>
                        <p>Aucun lot sélectionné.</p>
                    <?php else: ?>
                        <?php
                        $ids = implode(',', array_keys($_SESSION['commande_en_cours']));
                        $stmt = $pdo->query("SELECT Lot_ID, Modele_Lot FROM lot WHERE Lot_ID IN ($ids)");
                        $infos = $stmt->fetchAll(PDO::FETCH_UNIQUE);
                        foreach ($_SESSION['commande_en_cours'] as $id => $qte):
                            if (!isset($infos[$id])) continue;
                            ?>
                            <div>
                                <?= htmlspecialchars($infos[$id]['Modele_Lot']) ?> × <?= $qte ?>
                                <a href="?retirer=<?= $id ?>" style="color:red; margin-left: 10px;">[X]</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

