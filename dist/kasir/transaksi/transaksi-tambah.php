<?php
require_once '../../config.php';
$produkList = query("SELECT * from stok left join produk on produk.produkID = stok.produkID");
?><div class="container-fluid my-5 px-4">
    <div class="main-panel">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title m-0">Tambah Transaksi</h3>
                    <div class="text-muted" id="tanggal-transaksi"></div>
                </div>

                <div class="mb-3">
                    <label for="searchID">Masukkan ID Produk</label>
                    <input type="text" name="searchID" id="searchID" class="form-control"
                        placeholder="Contoh: 101 atau kodeProduk">
                </div>

                <form id="formTransaksi">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-produk">
                                <!-- Baris produk ditambahkan dengan JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-2 text-end">
                        <strong>Total Item: <span id="total-item">0</span></strong>
                    </div>
                    <div class="mb-2 text-end">
                        <strong>Total Harga: <span id="total-harga">Rp. 0</span></strong>
                        <input type="hidden" name="totalHarga" id="totalHarga">
                    </div>

                    <div class="row justify-content-end mb-3">
                        <div class="col-md-3">
                            <label>Total Bayar</label>
                            <input type="number" name="totalBayar" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Kembalian</label>
                            <input type="number" name="kembalian" id="kembalian" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" id="btn-hapus-semua" class="btn btn-danger">
                            Hapus Semua
                        </button>
                        <button type="submit" name="tambah" class="btn" style="background-color: #403E92; color:white;">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("btn-hapus-semua").addEventListener("click", function() {
    const tbody = document.querySelector("#tabel-produk");
    if (tbody.children.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Tidak ada data',
            text: 'Tidak ada produk untuk dihapus.'
        });
        return;
    }

    Swal.fire({
        title: 'Hapus Semua Produk?',
        text: 'Semua produk akan dihapus dari daftar!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#403E92',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, Hapus Semua'
    }).then((result) => {
        if (result.isConfirmed) {
            tbody.innerHTML = '';
            updateTotal();
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const tanggalEl = document.getElementById("tanggal-transaksi");

    function updateWaktu() {
        const now = new Date();

        const tanggal = now.toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        });

        const jam = now.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"
        });

        tanggalEl.textContent = `${tanggal} — ${jam}`;
    }

    // Set awal dan perbarui tiap detik
    updateWaktu();
    setInterval(updateWaktu, 1000);
});

// Tangani Enter di input qty → update subtotal, bukan submit form
document.addEventListener('keydown', function(e) {
    if (e.target.classList.contains('qty-input') && e.key === 'Enter') {
        e.preventDefault(); // Hindari submit form
        const row = e.target.closest('tr');
        updateSubtotal(row);
        updateTotal();

        e.target.blur(); // atau comment jika ingin tetap fokus
    }
});

document.querySelector('input[name="searchID"]').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const id = this.value.trim();

        if (id !== '') {
            fetch('product-search.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'produkID=' + encodeURIComponent(id)
                })
                .then(res => res.json())
                .then(response => {
                    if (response.status === 'success') {
                        const produk = response.data;

                        // Tambah ke tabel atau form
                        tambahProdukKeTabel(produk);
                        this.value = '';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Produk tidak ditemukan',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(err => {
                    console.error('AJAX Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menghubungi Server',
                        text: 'Silakan coba beberapa saat lagi.'
                    });
                });
        }
    }
});

// Simpan nilai lama saat fokus (klik/input) di qty
document.addEventListener('focusin', function(e) {
    if (e.target.classList.contains('qty-input')) {
        e.target.dataset.old = e.target.value;
    }
});

// Validasi saat qty diubah langsung
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('qty-input')) {
        let qty = parseInt(e.target.value || 0);
        const stok = parseInt(e.target.dataset.stok);
        const oldQty = parseInt(e.target.dataset.old);

        if (qty > stok) {
            e.target.value = oldQty;
            Swal.fire({
                icon: 'warning',
                title: 'Qty Melebihi Stok',
                text: `Maksimal hanya ${stok} item.`,
                confirmButtonText: 'OK'
            });
        } else if (qty < 1 || isNaN(qty)) {
            e.target.value = 1;
        }

        updateSubtotal(e.target.closest('tr'));
        updateTotal();
    }
});

function tambahProdukKeTabel(produk) {
    const tbody = document.querySelector('table tbody');

    let existing = [...tbody.children].find(row => row.dataset.id === produk.produkID);
    if (existing) {
        const qtyInput = existing.querySelector('.qty-input');
        let currentQty = parseInt(qtyInput.value);
        let stok = parseInt(qtyInput.dataset.stok);
        if (currentQty < stok) {
            qtyInput.value = currentQty + 1;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis',
                text: `Stok hanya tersedia ${stok} item`
            });
        }
        updateSubtotal(existing);
    } else {
        let row = document.createElement('tr');
        row.dataset.id = produk.produkID;
        row.innerHTML = `
            <td class="text-center">#</td>
            <td>
                ${produk.namaProduk}
                <input type="hidden" name="produkID[]" value="${produk.produkID}">
            </td>
            <td>${produk.harga}</td>
            <td>
                <input type="number" class="form-control qty-input" value="1" name="quantity[]" min="1" max="${produk.jumlah}" 
                data-harga="${produk.harga}" data-stok="${produk.jumlah}"data-old="1"style="width: 80px;">
            </td>
            <td class="subtotal">${produk.harga}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm btn-hapus">Hapus</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    updateTotal();
}

function updateSubtotal(row) {
    const harga = parseInt(row.querySelector('.qty-input').dataset.harga);
    const qty = parseInt(row.querySelector('.qty-input').value);
    row.querySelector('.subtotal').textContent = harga * qty;
}

function updateTotal() {
    let totalItem = 0;
    let totalHarga = 0;
    document.querySelectorAll('table tbody tr').forEach(row => {
        const qty = parseInt(row.querySelector('.qty-input').value || 0);
        const harga = parseInt(row.querySelector('.qty-input').dataset.harga || 0);
        totalItem += qty;
        totalHarga += qty * harga;
        row.querySelector('.subtotal').textContent = qty * harga;
    });

    document.getElementById('total-item').textContent = totalItem;
    document.getElementById('total-harga').textContent = 'Rp. ' + totalHarga.toLocaleString();
    document.getElementById('totalHarga').value = totalHarga;

    // Kembalian (jika sudah diinput)
    const bayar = parseInt(document.querySelector('[name="totalBayar"]').value || 0);
    document.getElementById('kembalian').value = bayar - totalHarga > 0 ? bayar - totalHarga : 0;
}

// Hapus produk dari tabel
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-hapus')) {
        const row = e.target.closest('tr');
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk akan dihapus dari daftar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#403E92',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                row.remove();
                updateTotal();
            }
        });
    }
});

// Hitung kembalian secara otomatis saat total bayar diinput
let debounceTimeout;

document.querySelector('[name="totalBayar"]').addEventListener('input', function() {
    clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(() => {
        const total = parseInt(document.getElementById('totalHarga').value || 0);
        const bayar = parseInt(this.value || 0);
        const kembalian = bayar - total;

        if (!isNaN(bayar) && bayar > 0 && bayar.toString().length >= 3) {
            if (kembalian < 0) {
                const kekurangan = Math.abs(kembalian).toLocaleString('id-ID');
                Swal.fire({
                    icon: 'warning',
                    title: 'Bayaran Kurang',
                    text: `Bayaran anda kurang sebesar Rp ${kekurangan}`,
                    confirmButtonText: 'OK'
                });
                document.getElementById('kembalian').value = 0;
            } else {
                document.getElementById('kembalian').value = kembalian;
            }
        } else {
            document.getElementById('kembalian').value = 0;
        }
    }, 500); // Tunggu 500ms setelah user berhenti mengetik
});
</script>