<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['Id_utilisateur']);
}

function redirect_by_role($role) {
    switch ($role) {
        case 'Admin':
            header("Location: ajout_employe.php");
            break;
        case 'Employe':
            header("Location: suivi_commande.php");
            break;
        case 'Livreur':
            header("Location: suivi_commande.php");
            break;
        case 'Commercial':
            header("Location: creer_lot.php");
            break;
        case 'Manager':
            header("Location: ajout_employe.php");
            break;
        case 'Gestionnaire':
            header("Location: creer_lot.php");
            break;  
        case 'Directeur':
            header("Location: ajout_employe.php");
            break;
        default:
            header("Location: index.php");
    }
    exit;
}

function get_user_reference_id($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT id_reference FROM utilisateur WHERE id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    return $row ? $row['id_reference'] : null;
}

?>