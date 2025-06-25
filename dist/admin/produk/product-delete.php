<?php
require_once '../../../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["id"])) {
    $id = $_GET["id"];
    if (hapus($id) > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus data'
        ]);
    }
    exit;
}

?>