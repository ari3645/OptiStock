<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

//if (!is_logged_in() || $_SESSION['role'] !== 'admin') {
//    header("Location: index.php");
//    exit;
//}

 if (!isset($_SESSION['lot_en_cours'])) {
     $_SESSION['lot_en_cours'] = [];
 }

 if (isset($_GET['vider'])) {
     $_SESSION['lot_en_cours'] = [];
     header("Location: creer_lot.php");
     exit;
 }

 if (isset($_GET['ajouter']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
     $vet_id = (int)$_GET['ajouter'];
     $quantite = (int)$_POST['quantite'];

     if ($quantite > 0) {
         $stmt = $pdo->prepare("SELECT Nb_Stock FROM Article WHERE Article_ID = ?");
         $stmt->execute([$vet_id]);
         $stock = $stmt->fetchColumn();

         if ($stock !== false && $quantite <= $stock) {
             $_SESSION['lot_en_cours'][$vet_id] = ($_SESSION['lot_en_cours'][$vet_id] ?? 0) + $quantite;
         }
     }

     header("Location: creer_lot.php");
     exit;
 }

 if (isset($_GET['retirer'])) {
     unset($_SESSION['lot_en_cours'][(int)$_GET['retirer']]);
     header("Location: creer_lot.php");
     exit;
 }

 $success = "";
 $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creer_lot'])) {
    $nom_lot = trim($_POST['nom_lot']);
    $nb_lots = max(1, (int)$_POST['nb_lots']);
    $lot_items = $_SESSION['lot_en_cours'];
    $prix_total_lot = 0;
    $quantite_total_articles = 0;

    if (empty($nom_lot)) {
        $error = "Veuillez entrer un nom de lot.";
    } elseif (empty($lot_items)) {
        $error = "Aucun vêtement ajouté au lot.";
    } else {
        $manager_id = $_SESSION['Id_utilisateur'];
        $erreur_stock = false;
        $composition = [];

        foreach ($lot_items as $vet_id => $qte_par_lot) {
            $check = $pdo->prepare("SELECT Nb_Stock, Libelle_Article, sales_price FROM Article WHERE Article_ID = ?");
            $check->execute([$vet_id]);
            $data = $check->fetch();

            if (!$data) continue;

            $dispo = (int)$data['Nb_Stock'];
            $nom_vet = $data['Libelle_Article'];
            $prix_unitaire = (float)$data['sales_price'];
            $qte_totale = $qte_par_lot * $nb_lots;

            if ($dispo < $qte_totale) {
                $error = "Stock insuffisant pour <strong>$nom_vet</strong> (disponible : $dispo, demandé : $qte_totale)";
                $erreur_stock = true;
                break;
            }

            $prix_total_lot += $prix_unitaire * $qte_par_lot;
            $quantite_total_articles += $qte_par_lot;

            $composition[] = [
                'article_id' => $vet_id,
                'libelle' => $nom_vet,
                'quantite' => $qte_par_lot,
                'sales_price' => $prix_unitaire
            ];
        }

        if (!$erreur_stock) {
            $json_composition = json_encode($composition, JSON_UNESCAPED_UNICODE);

            $stmt = $pdo->prepare("
                INSERT INTO Lot (Modele_Lot, Createur_Lot, Nb_Lots, Prix_Lot, Composition, Quantite_Article)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $nom_lot,
                $manager_id,
                $nb_lots,
                $prix_total_lot,
                $json_composition,
                $quantite_total_articles
            ]);

            $_SESSION['lot_en_cours'] = [];
            $success = "Lot '$nom_lot' (x$nb_lots) créé avec succès.";
        }
    }
}


$mot_cle = trim($_GET['recherche'] ?? "");

if ($mot_cle) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM Article 
            WHERE Nb_Stock > 0 
            AND (
                Libelle_Article LIKE :mc1 
                OR Couleur LIKE :mc2 
                OR Taille LIKE :mc3
            )
        ");
        $like = '%' . $mot_cle . '%';
        $stmt->execute([
            'mc1' => $like,
            'mc2' => $like,
            'mc3' => $like
        ]);
    } catch (PDOException $e) {
        die("Erreur PDO : " . $e->getMessage());
    }
} else {
    $stmt = $pdo->query("SELECT * FROM Article WHERE Nb_Stock > 0");
}

$vets_disponibles = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un lot</title>
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
            <li><a href="creer_lot.php" class="active">Créer Lot</a></li>
            <li><a href="creer_commande.php">Créer Commande</a></li>
            <li><a href="realiser_commande.php">Réaliser Commande</a></li>
            <li><a href="reception_commande.php">Réception Fournisseur</a></li>
            <li><a href="suivi_commande.php">Suivi Commandes</a></li>
            <li><a href="visu_stock.php">Stocks</a></li>
            <li><a href="liste_utilisateurs.php">Liste Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Créer un nouveau lot de vêtements</h2>

    <?php if ($success): ?>
        <p class="message-success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="message-error"><?= $error ?></p>
    <?php endif; ?>

    <!-- Formulaire de recherche -->
<form method="GET" class="form-card search-form">
    <input type="text" name="recherche" placeholder="Recherche..." >
    <button type="submit" class="btn">Rechercher</button>
</form>

    <div class="flex-wrapper" style="margin-top: 30px;">

        <!-- Colonne vêtements -->
        <div class="form-section">
            <h3>Vêtements disponibles</h3>
            <div class="grid-articles">
                <?php foreach ($vets_disponibles as $vet): ?>
                    <?php
                    $stock = $vet['Nb_Stock'];
                    $dejajoutee = $_SESSION['lot_en_cours'][$vet['Article_ID']] ?? 0;
                    $restant = $stock - $dejajoutee;
                    ?>
                    <?php if ($restant > 0): ?>
                        <form method="POST" action="?ajouter=<?= $vet['Article_ID'] ?>" class="form-card">
                            <p><?= htmlspecialchars($vet['Libelle_Article']) ?><br><?= $vet['Taille'] ?> - <?= $vet['Couleur'] ?></p>
                            <label>Qté :</label>
                            <input type="number" name="quantite" min="1" max="<?= $restant ?>" value="1" required>
                            <button type="submit" class="btn">Ajouter</button>
                        </form>
                    <?php else: ?>
                        <div class="form-card">
                            <p><?= htmlspecialchars($vet['Libelle_Article']) ?><br><?= $vet['Taille'] ?> - <?= $vet['Couleur'] ?></p>
                            <span style="color:red;">Rupture de stock</span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="lot-en-cours-wrapper">
            <h3>Lot en cours</h3>
            <div class="lot-en-cours-content">

                <!-- Liste des articles dans le lot -->
                <div class="lot-articles">
                    <?php if (empty($_SESSION['lot_en_cours'])): ?>
                        <p>Aucun vêtement ajouté.</p>
                    <?php else: ?>
                        <?php
                        $ids = implode(',', array_keys($_SESSION['lot_en_cours']));
                        $stmt = $pdo->query("SELECT * FROM Article WHERE Article_ID IN ($ids)");
                        $vets = $stmt->fetchAll(PDO::FETCH_UNIQUE);
                        foreach ($_SESSION['lot_en_cours'] as $id => $qte):
                            if (!isset($vets[$id])) continue;
                            $v = $vets[$id];
                            ?>
                            <div>
                                <?= htmlspecialchars($v['Libelle_Article']) ?> - <?= $v['Taille'] ?> - <?= $v['Couleur'] ?> → <strong><?= $qte ?></strong>
                                <a href="?retirer=<?= $id ?>" style="color:red; margin-left: 5px;">[X]</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Formulaire de création -->
                <div class="lot-formulaire">
                    <form method="POST" class="form-card">
                        <label>Nom du lot :</label>
                        <input type="text" name="nom_lot" required>

                        <label>Nombre d’exemplaires :</label>
                        <input type="number" name="nb_lots" min="1" value="1" required>

                        <div class="button-group">
                            <button type="submit" name="creer_lot" class="btn">Créer le lot</button>
                            <a href="?vider=1" class="btn-secondary" onclick="return confirm('Vider complètement le lot ?');">Vider le lot</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

</body>
</html>
