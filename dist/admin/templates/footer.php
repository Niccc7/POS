<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script src="assets/js/dataTables.select.min.js"></script>
<script src="../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
<script src="../assets/js/data-table.js"></script>

<script src="../assets/js/off-canvas.js"></script>
<script src="../assets/js/template.js"></script>
<script src="../assets/js/settings.js"></script>
<script src="../assets/js/todolist.js"></script>

<script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
<script sr="../assets/js/dashboard.js"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/vendors/chart.js/chart.umd.js"></script>
<script src="../asset/script.js"></script>
<script>
document.getElementById('logoutBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Sesi Anda akan diakhiri.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#217753',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../../logout.php';
        }
    });
});
</script>

</html>