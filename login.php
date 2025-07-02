<?php
session_start();

if (isset($_SESSION['roles']) && !isset($_GET['status'])) {
    if ($_SESSION['roles'] === 'admin') {
        header("Location: dist/admin/index.php");
    } elseif ($_SESSION['roles'] === 'kasir') {
        header("Location: kasir/dashboard_kasir.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS - Login</title>
    <link rel="stylesheet" href="dist/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="dist/assets/css/style.css">
    <link rel="shortcut icon" href="dist/assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="dist/assets/images/logo.svg" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="post" id="loginForm">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-lg"
                                        placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        placeholder="Password">
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">SIGN IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="dist/assets/js/off-canvas.js"></script>
    <script src="dist/assets/js/template.js"></script>
    <script src="dist/assets/js/settings.js"></script>
    <script src="dist/assets/js/todolist.js"></script>
    <script>
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        const username = $('input[name="username"]').val().trim();
        const password = $('input[name="password"]').val().trim();

        if (!username || !password) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Username dan Password harus diisi!'
            });
            return;
        }

        Swal.fire({
            title: 'Mohon tunggu...',
            text: 'Sedang memproses login',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: 'auth.php',
            data: {
                username,
                password
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        text: 'Mengalihkan halaman...',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX ERROR:', jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan server.'
                });
            }
        });
    });
    </script>

</body>

</html>