<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<?php
$menu = $_GET['page'] ?? 'transaksi';
$id = $_GET['id'] ?? null;

?>

<div class="container-fluid page-body-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <?php
                            if ($menu == 'transaksi-detail' && $id) {
                                include 'transaksi/transaksi-detail.php';
                            } else if ($menu == 'transaksi') {
                                include 'transaksi/transaksi-read.php';
                            } else {
                                echo "<div class='alert alert-info'>Silakan pilih menu dari sidebar</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'templates/footer.php'; ?>
    </div>
</div>