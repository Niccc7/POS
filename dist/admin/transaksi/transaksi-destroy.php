<?php
require_once '../../../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $result = hapusTransaksi($_GET['id']);

    if ($result > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus transaksi'
        ]);
    }
    exit;
}

// Respon fallback jika tidak ada ID atau metode salah
echo json_encode([
    'status' => 'error',
    'message' => 'Permintaan tidak valid'
]);
exit;
?>