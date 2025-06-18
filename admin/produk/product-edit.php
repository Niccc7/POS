<?php 
require_once '../../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["edit"])) {
    $result = edit($_POST);

    echo json_encode([
        'status' => $result > 0 ? 'success' : 'error',
        'message' => $result > 0 ? 'Data berhasil diubah' : 'Tidak ada data yang diubah'
    ]);
    exit;
}
?>