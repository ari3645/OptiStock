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
    <title>Connexion</title>
</head>
<body>
<h2>Connexion</h2>
<form method="POST">
    <label>Login:</label>
    <input type="text" name="login" required>
    <br>
    <label>Mot de passe:</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Se connecter">
</form>
<p style="color:red;"><?= $error ?></p>
</body>
</html>
