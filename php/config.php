<?php
// php/config.php

// 1. Tes infos de connexion
$host     = '127.0.0.1';
$dbname   = 'nom_de_ta_bdd';
$username = 'root';
$password = '';         // ou ton mot de passe MySQL
$charset  = 'utf8mb4';

// 2. Construction du DSN
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// 3. Options PDO recommandées
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// 4. Création de l’objet PDO
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // En prod tu loggues plutôt que d’afficher l’erreur
    exit('⛔ Échec de la connexion à la BDD : ' . $e->getMessage());
}
