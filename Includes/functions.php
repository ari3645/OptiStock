<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_by_role($role) {
    switch ($role) {
        case 'manager':
            header("Location: dashboard.php?role=manager");
            break;
        case 'employe':
            header("Location: dashboard.php?role=employe");
            break;
        case 'livreur':
            header("Location: dashboard.php?role=livreur");
            break;
        case 'commercial':
            header("Location: dashboard.php?role=commercial");
            break;
        default:
            header("Location: login.php");
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