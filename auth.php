<?php
session_start();
require_once "config.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi
if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username dan password harus diisi!']);
    exit;
}

$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['roles'] = $user['roles'];

        if ($user['roles'] === 'admin') {
            echo json_encode(['status' => 'success', 'redirect' => 'dist/admin/index.php']);
        } elseif ($user['roles'] === 'kasir') {
            echo json_encode(['status' => 'success', 'redirect' => 'dist/kasir/index.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Role tidak dikenali.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan!']);
}