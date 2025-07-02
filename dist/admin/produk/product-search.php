<?php
require_once '../../../config.php';
header('Content-Type: application/json');

// Ambil dari POST
$produkID = $_POST['produkID'] ?? '';

if (!$produkID) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Produk ID kosong'
    ]);
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM produk 
    LEFT JOIN stok ON produk.produkID = stok.produkID 
    WHERE produk.produkID = '$produkID' OR kodeProduk = '$produkID'");

$data = mysqli_fetch_assoc($query);

if ($data) {
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Produk tidak ditemukan'
    ]);
}