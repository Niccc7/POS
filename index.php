<?php
session_start();

// Jika belum login
if (!isset($_SESSION['userID']) || !isset($_SESSION['roles'])) {
    header("Location: login.php");
    exit;
}

// Arahkan sesuai role
$role = $_SESSION['roles'];
if ($role === 'admin') {
    header("Location: dist/admin/index.php");
} elseif ($role === 'kasir') {
    header("Location: dist/kasir/index.php");
} else {
    // Role tidak dikenali, logoutkan
    header("Location: logout.php");
}
exit;
?>