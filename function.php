<?php

$conn = mysqli_connect("localhost", "root", "", "pos");
if (!$conn) {
    die("koneksi gagal");
}

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

?>