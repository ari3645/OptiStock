<?php
require_once 'includes/functions.php';
if (!is_logged_in()) header("Location: login.php");

$role = $_SESSION['role'];
echo "<h1>Bienvenue sur le tableau de bord ($role)</h1>";
echo '<p><a href="logout.php">Déconnexion</a></p>';
?>
