<?php 
require_once '../../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["tambah"])) {
    $result = tambah($_POST);

    if ($result > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data gagal ditambahkan'
        ]);
    }
    exit;
}

?>