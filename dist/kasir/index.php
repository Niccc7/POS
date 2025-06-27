<?php
$menu = $_GET['page'] ?? 'dashboard';
include 'templates/header.php';
include 'templates/navbar.php';

require_once '../../config.php';

$userID = $_SESSION['userID'] ?? 0;

// Ambil jumlah transaksi user yang sedang login
$jumlahTransaksi = 0;
if ($userID > 0) {
    $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE userID = '$userID'");
    $result = mysqli_fetch_assoc($query);
    $jumlahTransaksi = $result['total'] ?? 0;
}
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

                            <!-- Kartu total transaksi -->
                            <div class="card shadow-sm p-3 mt-3 bg-white rounded" style="max-width: 300px;">
                                <div class="d-flex align-items-center">
                                    <i class="menu-icon mdi mdi-cash-register text-primary"
                                        style="font-size: 28px;"></i>
                                    <div class="ms-3">
                                        <div class="fw-bold">Total Transaksi</div>
                                        <div class="fs-4"><?= $jumlahTransaksi ?></div>
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