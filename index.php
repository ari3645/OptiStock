<?php
session_start();
$role = $_SESSION['role'] ?? null;

switch ($role) {
  case 'admin':
    header("Location: /admin/dashboard.php");
    break;
  case 'commercial':
    header("Location: /commercial/dashboard.php");
    break;
  case 'employe':
    header("Location: /employe/dashboard.php");
    break;
  default:
    header("Location: /login.php");
    break;
}
exit;
?>
