<?php
require_once '../../function.php';
$tr = query("SELECT * from transaksi 
left join user on transaksi.userID = user.userID
");
?>

<div class="container my-5">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Table Transaksi</h4>
                            <a type="button" class="btn btn-primary" href="index.php?menu=transaksi&aksi=tambah">
                                Add Data
                            </a>
                            <div class="table-responsive">
                                <table class="table" id="tableProduct">
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
                                                    <a href="transaksi/transaksi-detail.php?id=<?= $t['transaksiID'] ?>">Lihat Detail</a>
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
            </div>
        </div>
    </div>

    <!-- Edit Data -->
    <div class="modal fade" id="editData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" method="post">
                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="kodeProduk" class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" id="edit-kode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="edit-nama" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Stok</label>
                            <input type="number" name="harga" class="form-control" id="edit-harga" required>
                        </div>
                        <div class="me-5">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>