<?php 
$currentFile = basename($_SERVER['PHP_SELF']);
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link <?= $currentFile == 'index.php' ? 'active' : '' ?>" href="index.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentFile == 'product.php' ? 'active' : '' ?>" href="product.php">
                <i class="menu-icon mdi mdi-cart"></i>
                <span class="menu-title">Product</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentFile == 'stock.php' ? 'active' : '' ?>" href="stock.php">
                <i class="menu-icon mdi mdi-database"></i>
                <span class="menu-title">Stock</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= in_array($currentFile, ['transaksi.php', 'transaksi-detail.php', 'transaksi-tambah.php']) ? 'active' : '' ?>"
                href="transaksi.php">
                <i class="menu-icon mdi mdi-cash-register"></i>
                <span class="menu-title">Transaksi</span>
            </a>
        </li>
    </ul>
</nav>