<?php
require_once '../../function.php';
$tr = query("SELECT * from transaksi 
left join user on transaksi.userID = user.userID
");
?>
<h2>Transaksi Baru</h2>
<form action="simpan_transaksi.php" method="post">
    <label>Produk 1:</label><br>
    <input type="number" name="produkID[0]" placeholder="ID Produk">
    <input type="number" name="qty[0]" placeholder="Qty"><br><br>

    <label>Produk 2:</label><br>
    <input type="number" name="produkID[1]" placeholder="ID Produk">
    <input type="number" name="qty[1]" placeholder="Qty"><br><br>

    <label>Produk 3:</label><br>
    <input type="number" name="produkID[2]" placeholder="ID Produk">
    <input type="number" name="qty[2]" placeholder="Qty"><br><br>

    <label>Total Bayar:</label><br>
    <input type="number" name="totalBayar"><br><br>

    <input type="submit" name="simpan" value="Simpan Transaksi">
</form>