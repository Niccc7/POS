<?php
include '../../../function.php';

$transaksiID = $_GET['id']; // ambil ID dari URL, contoh: detail.php?id=1

// Query untuk ambil data transaksi dan user
$queryTransaksi = mysqli_query($conn, "
  SELECT transaksi.*, user.name 
  FROM transaksi 
  JOIN user ON transaksi.userID = user.userID
  WHERE transaksi.transaksiID = $transaksiID
");
$transaksi = mysqli_fetch_assoc($queryTransaksi);

// Query untuk ambil detail produk dalam transaksi
$queryDetail = mysqli_query($conn, "
  SELECT td.*, p.kodeProduk, p.namaProduk, p.harga
  FROM transaksi_detail as td
  JOIN produk as p ON td.produkID = p.produkID
  WHERE td.transaksiID = $transaksiID
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background-color: #f8f9fa;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #dee2e6;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        .summary {
            margin-top: 20px;
        }

        .summary div {
            margin-bottom: 5px;
        }

        .status {
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Detail Transaksi</h2>

        <div class="summary">
            <div><strong>ID Transaksi:</strong> <?= $transaksi['transaksiID'] ?></div>
            <div><strong>Tanggal:</strong> <?= $transaksi['tglTransaksi'] ?></div>
            <div><strong>Nama Kasir:</strong> <?= $transaksi['name'] ?></div>
            <div><strong>Status:</strong> <span class="status"><?= $transaksi['statusTransaksi'] ?></span></div>
        </div>

        <h3>Daftar Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $grandTotal = 0;
                while ($row = mysqli_fetch_assoc($queryDetail)) {
                    $subtotal = $row['harga'] * $row['quantity'];
                    $grandTotal += $subtotal;
                    echo "<tr>
          <td>$no</td>
          <td>{$row['kodeProduk']}</td>
          <td>{$row['namaProduk']}</td>
          <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
          <td>{$row['quantity']}</td>
          <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
        </tr>";
                    $no++;
                }
                ?>

                <a href="../transaksi.php" class="btn btn-primary" type="button">Hapus Data</a>
            </tbody>
        </table>

        <div class="summary">
            <div><strong>Total Harga:</strong> Rp<?= number_format($transaksi['totalHarga'], 0, ',', '.') ?></div>
            <div><strong>Total Bayar:</strong> Rp<?= number_format($transaksi['totalBayar'], 0, ',', '.') ?></div>
            <div><strong>Kembalian:</strong>
                Rp<?= number_format($transaksi['totalBayar'] - $transaksi['totalHarga'], 0, ',', '.') ?></div>
        </div>
    </div>
</body>

</html>