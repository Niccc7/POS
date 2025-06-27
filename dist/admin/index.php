<?php
$menu = $_GET['page'] ?? 'dashboard';
include 'templates/header.php';
include 'templates/navbar.php';

require_once '../../config.php';

// Jumlah transaksi semua user
$queryTransaksi = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi");
$totalTransaksi = mysqli_fetch_assoc($queryTransaksi)['total'] ?? 0;

// Jumlah produk
$queryProduk = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
$totalProduk = mysqli_fetch_assoc($queryProduk)['total'] ?? 0;

// Jumlah total stok (jumlah barang dari semua produk)
$queryStok = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM stok");
$totalStok = mysqli_fetch_assoc($queryStok)['total'] ?? 0;
?>

<div class="container-fluid page-body-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">

                        <?php if ($menu === 'dashboard') : ?>
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Welcome, <?= $_SESSION['username'] ?></h3>
                        </div>
                        <div class="row">

                            <!-- Total Transaksi -->
                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm p-3 bg-white rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="menu-icon mdi mdi-cash-register text-primary"
                                            style="font-size: 28px;"></i>
                                        <div class="ms-3">
                                            <div class="fw-bold">Total Transaksi</div>
                                            <div class="fs-4"><?= $totalTransaksi ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Produk -->
                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm p-3 bg-white rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="menu-icon mdi mdi-cube-outline text-info"
                                            style="font-size: 28px;"></i>
                                        <div class="ms-3">
                                            <div class="fw-bold">Jumlah Produk</div>
                                            <div class="fs-4"><?= $totalProduk ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Stok -->
                            <div class="col-md-4 mb-3">
                                <div class="card shadow-sm p-3 bg-white rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="menu-icon mdi mdi-package-variant-closed text-warning"
                                            style="font-size: 28px;"></i>
                                        <div class="ms-3">
                                            <div class="fw-bold">Total Stok</div>
                                            <div class="fs-4"><?= $totalStok ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>

                        <?php
                        $pages = [
                            'product'           => 'produk/product-read.php',
                            'stock'             => 'stok/stock-read.php',
                            'transaksi'         => 'transaksi/transaksi-read.php',
                            'transaksi-detail'  => 'transaksi/transaksi-detail.php',
                            'transaksi-tambah'  => 'transaksi/transaksi-tambah.php',
                        ];

                        if (array_key_exists($menu, $pages)) {
                            include $pages[$menu];
                        } else if ($menu !== 'dashboard') {
                            echo "<div class='alert alert-info'>Silakan pilih menu dari sidebar</div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>