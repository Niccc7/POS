<?php
include '../../config.php';

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

<div class="container-fluid py-4 px-4">
    <div class="card w-100">
        <div class="card-body">
            <h2 class="card-title text-center">Detail Transaksi</h2>
            <a type="button" class="btn mb-3" style="background-color: #217753; color:white;" href="transaksi.php">
                Back
            </a>

            <h5><strong>Tanggal:</strong> <?= date("d-m-Y H:i:s", strtotime($transaksi['tglTransaksi'])) ?></h5>
            <h5><strong>Kasir:</strong> <?= htmlspecialchars($transaksi['name']) ?></h5>

            <hr>

            <h4>Daftar Produk</h4>
            <div class="table-responsive">
                <table class="table text-nowrap" style="min-width: 900px;">
                    <thead class="table-secondary">
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
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['kodeProduk'] ?></td>
                            <td><?= $row['namaProduk'] ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <?php } ?>

                        <!-- Ringkasan Total -->
                        <tr class="table-light fw-bold">
                            <td colspan="5" class="text-end">Total Harga</td>
                            <td>Rp <?= number_format($transaksi['totalHarga'], 0, ',', '.') ?></td>
                        </tr>
                        <tr class="table-light fw-bold">
                            <td colspan="5" class="text-end">Total Bayar</td>
                            <td>Rp <?= number_format($transaksi['totalBayar'], 0, ',', '.') ?></td>
                        </tr>
                        <tr class="table-light fw-bold">
                            <td colspan="5" class="text-end">Kembalian</td>
                            <td>Rp
                                <?= number_format($transaksi['totalBayar'] - $transaksi['totalHarga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> <!-- card-body -->
    </div> <!-- card -->
</div>