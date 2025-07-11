<?php
require_once '../../function.php';
$loginUserID = $_SESSION['userID'] ?? 0;

$users = query("SELECT * FROM user WHERE userID != $loginUserID");
?>

<div class="container my-5">
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="text-center mb-4">List Kasir</h4>

                <div class="d-flex justify-content-start mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addData"
                        name="tambah">
                        <i class="mdi mdi-plus"></i> Add Data
                    </button>
                </div>

                <div class="row">
                    <?php foreach ($users as $user): ?>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3" style="background-color: #fff9e6	;">
                            <div class="card-body">
                                <h5 class="fw-bold"><?= htmlspecialchars($user['name']) ?></h5>
                                <p class="mb-1"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?>
                                </p>
                                <p><strong>Role:</strong> <?= htmlspecialchars($user['roles']) ?></p>

                                <div class="d-flex justify-content-between">
                                    <a href="edit_user.php?id=<?= $user['userID'] ?>"
                                        class="btn btn-sm btn-outline-warning">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <a href="hapus_user.php?id=<?= $user['userID'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="mdi mdi-delete"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

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
                        <label for="kodeProduk" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
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