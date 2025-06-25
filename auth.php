<?php
session_start();
require_once "config.php";

// Ambil input dari form login
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($username) || empty($password)) {
    die("Username dan password harus diisi!");
}

// Ambil user dari database berdasarkan username
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Cocokkan password menggunakan password_verify
    if (password_verify($password, $user['password'])) {
        // Login berhasil, buat session
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['roles'] = $user['roles'];

        // Arahkan berdasarkan role
        if ($user['roles'] === 'admin') {
            header("Location: dist/admin/index.php");
            exit;
        } elseif ($user['roles'] === 'kasir') {
            header("Location: dashboard_kasir.php");
            exit;
        } else {
            echo "Role tidak dikenali!";
        }
    } else {
        echo "Password salah!";
    }
} else {
    echo "User tidak ditemukan!";
}
?>