<?php
session_start();
if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'kasir') {
    header("Location: login.php");
    exit;
}
echo "Selamat datang Kasir: " . $_SESSION['username'];
?>