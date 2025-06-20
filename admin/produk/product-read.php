<?php
require_once '../function.php';
$product = query("SELECT  
                            produk.kodeProduk,
                            produk.produkID,
                            produk.namaProduk,
                            produk.harga,
                            stok.jumlah
                        FROM 
                            produk
                        LEFT JOIN
                            stok ON produk.produkID = stok.produkID

");
?>

<div class="container my-5">
    <h1 class="mb-4">Daftar Produk</h1>
    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addData" name="tambah">
        Add Data
    </a>

    <div>
        <div class="card-body">
            <table id="tableProduct" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="200">Kode Produk</th>
                        <th width="150">Nama Produk</th>
                        <th width="150">Price</th>
                        <th width="50">Stock</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($product as $prd): ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $prd["kodeProduk"] ?></td>
                        <td><?= $prd["namaProduk"] ?></td>
                        <td><?= $prd["harga"] ?></td>
                        <td><?= $prd["jumlah"] ?></td>
                        <td>
                            <a href="#" class="btn-edit" data-id="<?= $prd["produkID"]; ?>" name="edit"
                                data-kode-produk="<?= htmlspecialchars($prd["kodeProduk"]); ?>"
                                data-nama-produk="<?= htmlspecialchars($prd["namaProduk"]); ?>"
                                data-harga="<?= $prd["harga"]; ?>" data-bs-toggle="modal" data-bs-target="#editData"
                                style="cursor: pointer; text-decoration: none;">
                                <span class="badge text-bg-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                            </a>
                            <a class="hapus" href="produk/product-delete.php?id=<?= $prd["produkID"]; ?>"
                                style="cursor: pointer;">
                                <span class="badge text-bg-danger">
                                    <i class="bi bi-trash-fill"></i>
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

<!-- Tambah Data -->
<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambah" method="post">
                    <div class="mb-3">
                        <label for="kodeProduk" class="form-label">Kode Produk</label>
                        <input type="text" name="kode_produk" class="form-control" id="kode_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="nama_produk" class="form-control" id="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Price</label>
                        <input type="number" name="harga" class="form-control" id="harga" required>
                    </div>
                    <div class="me-5">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
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
                        <input type="text" name="kode_produk" class="form-control" id="edit-kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="nama_produk" class="form-control" id="edit-nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Price</label>
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