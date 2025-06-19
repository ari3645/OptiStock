<?php
require_once 'includes/functions.php';
if (is_logged_in()) {
    redirect_by_role($_SESSION['role']);
} else {
    header("Location: login.php");
}
exit;
?>
