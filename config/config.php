<?php
$host = '192.168.10.105,1433'; // ✅ Utiliser une virgule
$dbname = 'VDRM_BDD';    
$username = 'dev_user'; 
$password = 'K4bf8Ahb23Jnhy';

try {
    $pdo = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("❌ Connexion échouée : " . htmlspecialchars($e->getMessage()));
}
?>
