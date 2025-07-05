<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logout - CoreSell</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Logout berhasil',
        text: 'Anda telah keluar dari sesi.',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'login.php';
    });
    </script>
</body>

</html>