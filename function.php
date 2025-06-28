<?php
session_start();
require_once "config.php";

function query($query)
{
    global $conn;
    $hasil = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($hasil)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;
    $kode = htmlspecialchars($data["kode_produk"]);
    $name = htmlspecialchars($data["nama_produk"]);
    $harga = htmlspecialchars($data["harga"]);

    $query = "INSERT INTO produk (kodeProduk,namaProduk, harga)
                VALUES
                ('$kode','$name', '$harga')
                ";
    mysqli_query($conn, $query);

    // cek error
    if (mysqli_affected_rows($conn) < 1) {
        return 0;  // gagal insert produk
    }

    // 2) ambil ID produk yang baru saja dibuat
    $produkIdBaru = mysqli_insert_id($conn);

    // 3) masukkan stok awal = 0
    $Stok = "INSERT INTO stok (produkID, jumlah)
                VALUES ($produkIdBaru, 0)";
    mysqli_query($conn, $Stok);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE produkID = $id");
    return mysqli_affected_rows($conn);
}

function edit($data)
{
    global $conn;
    $id = $data['id'];
    $kode = htmlspecialchars($data['kode_produk']);
    $name = htmlspecialchars($data['nama_produk']);
    $harga = htmlspecialchars($data['harga']);

    $query = "UPDATE produk SET kodeProduk = '$kode', namaProduk = '$name', harga = '$harga' WHERE produkID = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function editStok($data) {
    global $conn;

    $id = $data['id'];
    $jumlah = $data['jumlah'];

    $query = "UPDATE stok SET jumlah = $jumlah WHERE produkID = $id";

    return mysqli_query($conn, $query);
}

function sendJson($status, $message, $extra = []) {
    return array_merge(['status' => $status, 'message' => $message], $extra);
}

function tambahTransaksi($data) {
    global $conn;   

    $produkIDs  = $data['produkID'] ?? [];
    $quantities = $data['quantity'] ?? [];
    $totalHarga = $data['totalHarga'] ?? 0;
    $totalBayar = $data['totalBayar'] ?? 0;
    $userID     = $_SESSION['userID'] ?? 1;

    if (empty($produkIDs) || empty($quantities)) {
        return sendJson('error', 'Data produk belum lengkap');
    }

    // Simpan header transaksi
    $sql = "INSERT INTO transaksi (userID, tglTransaksi, totalHarga, totalBayar, statusTransaksi) 
            VALUES ('$userID', NOW(), '$totalHarga', '$totalBayar', 'Done')";
    if (!mysqli_query($conn, $sql)) {
        return sendJson('error', 'Gagal menyimpan transaksi');
    }

    $transaksiID = mysqli_insert_id($conn);

    // Simpan detail dan update stok
    for ($i = 0; $i < count($produkIDs); $i++) {
        $produkID = (int)$produkIDs[$i];
        $qty      = (int)$quantities[$i];

        $stokRes  = mysqli_query($conn, "SELECT jumlah FROM stok WHERE produkID = '$produkID'");
        $hargaRes = mysqli_query($conn, "SELECT harga FROM produk WHERE produkID = '$produkID'");

        if (!$stokRes || !$hargaRes) {
            return sendJson('error', 'Produk tidak ditemukan');
        }

        $stok  = (int) mysqli_fetch_assoc($stokRes)['jumlah'];
        $harga = (int) mysqli_fetch_assoc($hargaRes)['harga'];

        if ($qty > $stok) {
            return sendJson('error', "Stok tidak mencukupi untuk produk ID $produkID");
        }

        $sqlDetail = "INSERT INTO transaksi_detail (transaksiID, produkID, quantity) 
                      VALUES ('$transaksiID', '$produkID', '$qty')";
        mysqli_query($conn, $sqlDetail);

        $sqlUpdateStok = "UPDATE stok SET jumlah = jumlah - $qty WHERE produkID = '$produkID'";
        mysqli_query($conn, $sqlUpdateStok);
    }

    return sendJson('success', 'Transaksi berhasil disimpan', ['transaksiID' => $transaksiID]);
}

function hapusTransaksi($id) {
    global $conn;

    $id = (int)$id; 

    $hapusTransaksi = mysqli_query($conn, "DELETE FROM transaksi WHERE transaksiID = $id");

    return $hapusTransaksi ? mysqli_affected_rows($conn) : 0;
}

?>