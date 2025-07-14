<?php
require_once '../../config.php';
$tr = query("SELECT * from transaksi 
left join user on transaksi.userID = user.userID
");
?>

<div class="container-fluid py-4">
    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title text-center">Table Transaksi</h4>
            <a type="button" class="btn mb-3" style="background-color: #217753; color:white;"
                href="transaksi.php?page=transaksi-tambah">
                Add Data
            </a>
            <div class="table-responsive">
                <table class="table w-100 text-nowrap" id="tableTr" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Tanggal Transaksi</th>
                            <th width="50">Total Harga</th>
                            <th width="50">Total Bayar</th>
                            <th width="50">Kembalian</th>
                            <th width="50">Kasir</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($tr as $t): ?>
                        <?php $k = $t["totalBayar"] - $t["totalHarga"]; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($t["tglTransaksi"])); ?></td>
                            <td><?= 'Rp ', number_format($t['totalHarga'], 0, ',', '.') ?></td>
                            <td><?= 'Rp ', number_format($t['totalBayar'], 0, ',', '.') ?></td>
                            <td><?= 'Rp ', number_format($k, 0, ',', '.') ?></td>
                            <td><?= $t["name"] ?></td>
                            <td>
                                <a href="transaksi.php?page=transaksi-detail&id=<?= $t['transaksiID']; ?>"
                                    class="btn btn-sm" style="background-color: #217753; color:white;">
                                    <i class="bi bi-eye" style="font-size: 14px;"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>