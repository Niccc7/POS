<?php
require_once '../function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php?menu=product">Product</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?menu=stock">Stock</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?menu=transaksi">Transaksi</a>
        </li>
    </ul>
    <hr>

    <?php
    $menu = isset($_GET['menu']) ? $_GET['menu'] : 'product';
    if ($menu == "product") {
        include "produk/product-read.php";
    } else if ($menu == "stock") {
        include "stok/stock-read.php";
    } else if ($menu == "transaksi") {
        include "transaksi/transaksi-read.php";
    } else {
        echo "Halaman tidak ditemukan";
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#tableProduct').DataTable();
    });
    </script>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../asset/script.js"></script>

</html>