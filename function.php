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

?>