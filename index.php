<?php
require_once 'config/config.php';
require_once 'includes/functions.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        redirect_by_role($user['role']);
    } else {
        $error = "Identifiants incorrects.";
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
<body>

<div class="login-container">
    <img src="images/logo.png" alt="Logo" class="logo">
    <h2>Connexion</h2>
    <form id="loginForm" method="POST" onsubmit="return validateForm()">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Se connecter">
    </form>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
</div>
<a href="ajout_employe.php">
    <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
        Ajouter un employé
    </button>
</a>

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
