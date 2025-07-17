<?php
$host = '192.168.10.105,1433';
$dbname = 'VDRM_BDD';
$username = 'dev_user';
$password = 'K4bf8Ahb23Jnhy';

try {
    $dsn = "sqlsrv:Server=$host;Database=$dbname;TrustServerCertificate=True";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("❌ Connexion échouée : " . htmlspecialchars($e->getMessage()));
}
?>
