<?php 
require_once '../../../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["reset"])) {
    $result = resetPasswordKasir($_POST);

    if ($result > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Password berhasil direset ke 12345'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mereset password'
        ]);
    }
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Metode tidak valid'
]);