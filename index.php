<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['Email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($login) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE Email = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user) {
            $motDePasseBDD = $user['MotDePasse'];
            $verification = ($password === $motDePasseBDD);

            echo "<p>Résultat de password_verify : " . ($verification ? 'true' : 'false') . "</p>";

            if ($verification) {
                $_SESSION['Id_utilisateur'] = $user['ID_Utilisateur'];
                $_SESSION['fonction'] = $user['Fonction'];
                redirect_by_role($user['Fonction']);
                exit(); 
            } else {
                $error = "Identifiants incorrects.";
            }
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Connexion</title>
    
</head>
<body class="login-page">

<div class="login-container">
    <img src="images/logo.svg" alt="Logo" class="logo">
    <h2>Connexion</h2>
    <form id="loginForm" method="POST" onsubmit="return validateForm()">
        <label for="Email">Email:</label>
        <input type="text" name="Email" id="Email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Se connecter">
    </form>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
</div>

<script>
    function validateForm() {
        const login = document.getElementById('login').value.trim();
        const password = document.getElementById('password').value.trim();

        if (login === '' || password === '') {
            alert('Veuillez remplir tous les champs.');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
