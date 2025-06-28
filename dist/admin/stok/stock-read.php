<?php
require_once '../../function.php';
$stok = query("SELECT * from stok left join produk on produk.produkID = stok.produkID
");
?>

<div class="container my-5">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Table Stock</h4>
                            <div class="table-responsive">
                                <table class="table" id="tableProduct">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="200">Kode Produk</th>
                                            <th width="150">Nama Produk</th>
                                            <th width="50">Stock</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($stok as $s): ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $s["kodeProduk"] ?></td>
                                            <td><?= $s["namaProduk"] ?></td>
                                            <td><?= $s["jumlah"] ?></td>
                                            <td>
                                                <a href="#" class="btn-edit-stok" data-id="<?= $s["produkID"]; ?>"
                                                    name="edit"
                                                    data-kode-produk="<?= htmlspecialchars($s["kodeProduk"]); ?>"
                                                    data-nama-produk="<?= htmlspecialchars($s["namaProduk"]); ?>"
                                                    data-stok="<?= $s["jumlah"]; ?>" data-bs-toggle="modal"
                                                    data-bs-target="#editDataStok"
                                                    style="cursor: pointer; text-decoration: none;">
                                                    <span class="badge text-bg-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </span>
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
            </div>
        </div>
    </div>
</div>

<!-- Edit Data -->
<div class="modal fade" id="editDataStok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditStok" method="post">
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
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" name="jumlah" class="form-control" id="edit-stok" required>
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