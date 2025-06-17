<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? '';

    // Validasi sederhana
    if (empty($name) || empty($username) || empty($password) || empty($role)) {
        echo "Semua field wajib diisi!";
    } else {
        // Cek apakah username sudah digunakan
        $check = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "Username sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan user
            $sql = "INSERT INTO user (name, username, password, roles) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $username, $hashed_password, $role);

            if ($stmt->execute()) {
                echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
            } else {
                echo "Gagal menyimpan user: " . $stmt->error;
            }
        }
    }
}
?>

<!-- Form Register -->
<h2>Form Registrasi</h2>
<form method="post" action="">
    <input type="text" name="name" placeholder="Nama Lengkap" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="kasir">Kasir</option>
    </select><br>
    <button type="submit">Register</button>
</form>