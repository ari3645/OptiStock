<?php
$host = 'localhost';           // ou adresse IP
$dbname = 'nom_de_ta_base';    // à adapter
$username = 'ton_utilisateur'; // à adapter
$password = 'ton_mot_de_passe';// à adapter

try {
    $pdo = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // mode exception
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // fetch par défaut
} catch (PDOException $e) {
    die("❌ Connexion échouée : " . htmlspecialchars($e->getMessage()));
}
?>
