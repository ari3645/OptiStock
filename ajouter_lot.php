<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

if (!is_logged_in() || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit;
}

// Initialisation du panier si absent
if (!isset($_SESSION['lot_en_cours'])) {
    $_SESSION['lot_en_cours'] = [];
}

// Vider entièrement le panier
if (isset($_GET['vider'])) {
    $_SESSION['lot_en_cours'] = [];
    header("Location: ajouter_lot.php");
    exit;
}

// Ajouter un vêtement au panier
if (isset($_GET['ajouter']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $vet_id = (int)$_GET['ajouter'];
    $quantite = (int)$_POST['quantite'];

    if ($quantite > 0) {
        $stmt = $pdo->prepare("SELECT quantite FROM vetement WHERE id = ?");
        $stmt->execute([$vet_id]);
        $stock = $stmt->fetchColumn();

        if ($stock !== false && $quantite <= $stock) {
            $_SESSION['lot_en_cours'][$vet_id] = ($_SESSION['lot_en_cours'][$vet_id] ?? 0) + $quantite;
        }
    }

    header("Location: ajouter_lot.php");
    exit;
}

// Retirer un vêtement du panier
if (isset($_GET['retirer'])) {
    unset($_SESSION['lot_en_cours'][(int)$_GET['retirer']]);
    header("Location: ajouter_lot.php");
    exit;
}

$success = "";
$error = "";

// Traitement du formulaire de création de lot
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creer_lot'])) {
    $nom_lot = trim($_POST['nom_lot']);
    $nb_lots = max(1, (int)$_POST['nb_lots']);
    $emplacement_lot = trim($_POST['emplacement_lot']);
    $lot_items = $_SESSION['lot_en_cours'];

    if (empty($nom_lot)) {
        $error = "Veuillez entrer un nom de lot.";
    } elseif (empty($emplacement_lot)) {
        $error = "Veuillez spécifier un emplacement.";
    } elseif (empty($lot_items)) {
        $error = "Aucun vêtement ajouté au lot.";
    } else {
        $manager_id = get_user_reference_id($pdo, $_SESSION['user_id']);
        $erreur_stock = false;

        foreach ($lot_items as $vet_id => $qte_par_lot) {
            $check = $pdo->prepare("SELECT quantite, nom FROM vetement WHERE id = ?");
            $check->execute([$vet_id]);
            $data = $check->fetch();

            $dispo = (int)$data['quantite'];
            $nom_vet = $data['nom'];
            $qte_totale = $qte_par_lot * $nb_lots;

            if ($dispo < $qte_totale) {
                $error = "Stock insuffisant pour <strong>$nom_vet</strong> (disponible : $dispo, demandé : $qte_totale)";
                $erreur_stock = true;
                break;
            }
        }

        if (!$erreur_stock) {
            // Création d’un seul lot avec la quantité souhaitée
            $stmt = $pdo->prepare("INSERT INTO lot (nom, cree_par, emplacement, quantite) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom_lot, $manager_id, $emplacement_lot, $nb_lots]);
            $lot_id = $pdo->lastInsertId();

            foreach ($lot_items as $vet_id => $qte_par_lot) {
                $insert = $pdo->prepare("INSERT INTO lot_vetement (lot_id, vetement_id, quantite) VALUES (?, ?, ?)");
                $insert->execute([$lot_id, $vet_id, $qte_par_lot]);

                $update = $pdo->prepare("UPDATE vetement SET quantite = quantite - ? WHERE id = ?");
                $update->execute([$qte_par_lot * $nb_lots, $vet_id]);
            }

            $_SESSION['lot_en_cours'] = [];
            $success = "Lot '$nom_lot' (x$nb_lots) créé avec succès.";
        }
    }
}

// Récupération des vêtements disponibles (avec filtre optionnel)
$mot_cle = $_GET['recherche'] ?? "";
if ($mot_cle) {
    $stmt = $pdo->prepare("SELECT * FROM vetement WHERE quantite > 0 AND (nom LIKE :mc OR couleur LIKE :mc OR taille LIKE :mc)");
    $stmt->execute(['mc' => '%' . $mot_cle . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM vetement WHERE quantite > 0");
}
$vets_disponibles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un lot</title>
</head>
<body>
<h2>Créer un nouveau lot de vêtements</h2>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<!-- Formulaire de recherche -->
<form method="GET">
    <input type="text" name="recherche" placeholder="Recherche..." value="<?= htmlspecialchars($mot_cle) ?>">
    <button type="submit">Rechercher</button>
</form>

<div style="display:flex;gap:30px;">
    <!-- Colonne vêtements -->
    <div style="width:50%;">
        <h3>Vêtements disponibles</h3>
        <?php foreach ($vets_disponibles as $vet): ?>
            <?php
            $stock = $vet['quantite'];
            $dejajoutee = $_SESSION['lot_en_cours'][$vet['id']] ?? 0;
            $restant = $stock - $dejajoutee;
            ?>
            <?php if ($restant > 0): ?>
                <form method="POST" action="?ajouter=<?= $vet['id'] ?>">
                    <?= htmlspecialchars($vet['nom']) ?> - <?= $vet['taille'] ?> - <?= $vet['couleur'] ?> (Stock: <?= $restant ?>)
                </br>
                    Quantité :
                    <input type="number" name="quantite" min="1" max="<?= $restant ?>" value="1" required>
                    <button type="submit">Ajouter</button>
                </form>
            <?php else: ?>
                <p><?= htmlspecialchars($vet['nom']) ?> - <?= $vet['taille'] ?> - <?= $vet['couleur'] ?> → <span style="color:red;">Rupture de stock</span></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Colonne lot en cours -->
    <div style="width:50%;">
        <h3>Lot en cours</h3>
        <?php if (empty($_SESSION['lot_en_cours'])): ?>
            <p>Aucun vêtement ajouté.</p>
        <?php else: ?>
            <?php
            $ids = implode(',', array_keys($_SESSION['lot_en_cours']));
            $stmt = $pdo->query("SELECT * FROM vetement WHERE id IN ($ids)");
            $vets = $stmt->fetchAll(PDO::FETCH_UNIQUE);
            foreach ($_SESSION['lot_en_cours'] as $id => $qte):
                if (!isset($vets[$id])) continue;
                $v = $vets[$id];
                ?>
                <div>
                    <?= htmlspecialchars($v['nom']) ?> - <?= $v['taille'] ?> - <?= $v['couleur'] ?> → <strong><?= $qte ?></strong>
                    <a href="?retirer=<?= $id ?>" style="color:red;">[X]</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="GET" onsubmit="return confirm('Vider complètement le lot ?');">
            <input type="hidden" name="vider" value="1">
            <button type="submit" style="color:red;">Vider le lot</button>
        </form>

        <hr>

        <form method="POST">
            <label>Nom du lot :</label><br>
            <input type="text" name="nom_lot" required><br><br>

            <label>Nombre d’exemplaires à créer :</label><br>
            <input type="number" name="nb_lots" min="1" value="1" required><br><br>

            <label>Emplacement du lot :</label><br>
            <input type="text" name="emplacement_lot" required><br><br>

            <button type="submit" name="creer_lot">Créer le lot</button>
        </form>
    </div>
</div>
</body>
</html>
