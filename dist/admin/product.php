<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<?php
$menu = $_GET['page'] ?? 'product';
?>

<div class="container-fluid page-body-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <?php
                            include 'produk/product-read.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'templates/footer.php'; ?>
    </div>
</div>