<?php


try {
    $pdo = new PDO('mysql:host=192.168.10.40;dbname=VDRM_BDD', 'dev_user', 'K4bf8Ahb23Jnhy');
    echo "Connexion réussie !";
} catch (PDOException $e) {
    //echo "Erreur : " . $e->getMessage();
    echo "";
}

?>