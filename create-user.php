<?php
require_once 'config/config.php';

$login = 'admin';
$password = password_hash('1234', PASSWORD_DEFAULT); // mot de passe : 1234
$role = 'manager';
$id_ref = 1; // à adapter si tu as un vrai manager en table

$stmt = $pdo->prepare("INSERT INTO utilisateur (login, mot_de_passe, role, id_reference) VALUES (?, ?, ?, ?)");
$stmt->execute([$login, $password, $role, $id_ref]);

echo "Utilisateur 'admin' ajouté avec succès.";
?>
