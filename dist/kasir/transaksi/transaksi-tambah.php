<?php
require_once '../../config.php';
$produkList = query("SELECT * from stok left join produk on produk.produkID = stok.produkID");
?>

<div class="container my-5">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Tambah Transaksi</h3>
                    <form id="formTransaksi">
                        <div id="produk-wrapper">
                            <div class="produk-item row mb-3">
                                <div class="col-md-3">
                                    <label>Produk</label>
                                    <select name="produkID[]" class="form-control produk-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        <?php foreach ($produkList as $prd): ?>
                                        <option value="<?= $prd['produkID'] ?>" data-harga="<?= $prd['harga'] ?>"
                                            data-stok="<?= $prd['jumlah'] ?>">
                                            <?= $prd['kodeProduk'] ?> - <?= $prd['namaProduk'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Harga</label>
                                    <input type="number" class="form-control harga" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label>Jumlah</label>
                                    <input type="number" name="quantity[]" class="form-control quantity" min="1"
                                        required>
                                </div>
                                <div class="col-md-2">
                                    <label>Subtotal</label>
                                    <input type="number" class="form-control subtotal" readonly>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" id="tambah-produk">+ Tambah Produk</button>

                        <div class="mb-3 mt-3">
                            <label><strong>Grand Total (Rp)</strong></label>
                            <input type="number" name="totalHarga" id="grandTotal" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label><strong>Total Bayar (Rp)</strong></label>
                            <input type="number" name="totalBayar" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label><strong>Total Kembalian (Rp)</strong></label>
                            <input type="number" name="kembalian" id="kembalian" class="form-control" readonly>
                        </div>

                        <button type="submit" name="tambah" class="btn btn-primary">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateHargaDanSubtotal(item) {
    const select = item.querySelector('.produk-select');
    const qtyInput = item.querySelector('.quantity');
    const hargaInput = item.querySelector('.harga');
    const subtotalInput = item.querySelector('.subtotal');

    const harga = parseInt(select.selectedOptions[0]?.dataset.harga || 0);
    const stok = parseInt(select.selectedOptions[0]?.dataset.stok || 0);
    let qty = parseInt(qtyInput.value || 0);

    if (!isNaN(qty) && qty > stok) {
        alert(`Jumlah melebihi stok tersedia (${stok})`);
        qty = stok;
        qtyInput.value = stok;
    }

    hargaInput.value = harga;
    subtotalInput.value = harga * qty;

    updateGrandTotal();
}

function updateGrandTotal() {
    const subtotals = document.querySelectorAll('.subtotal');
    let total = 0;
    subtotals.forEach(s => {
        total += parseInt(s.value || 0);
    });

    document.getElementById('grandTotal').value = total;
    updateKembalian(); // setiap kali total berubah, hitung kembalian
}

function updateKembalian() {
    const total = parseInt(document.getElementById('grandTotal').value || 0);
    const bayar = parseInt(document.querySelector('input[name="totalBayar"]').value || 0);
    const kembalian = bayar - total;
    document.getElementById('kembalian').value = kembalian >= 0 ? kembalian : 0;
}

document.getElementById('tambah-produk').addEventListener('click', function() {
    const wrapper = document.getElementById('produk-wrapper');
    const firstItem = wrapper.querySelector('.produk-item');
    const clone = firstItem.cloneNode(true);

    // Reset value dalam clone
    clone.querySelectorAll('input').forEach(input => input.value = '');
    clone.querySelector('select').selectedIndex = 0;

    wrapper.appendChild(clone);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-remove')) {
        const items = document.querySelectorAll('.produk-item');
        if (items.length > 1) {
            e.target.closest('.produk-item').remove();
            updateGrandTotal();
        }
    }
});

// Untuk produk / quantity berubah
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('produk-select') || e.target.classList.contains('quantity')) {
        const row = e.target.closest('.produk-item');
        updateHargaDanSubtotal(row);
    }
});

// Untuk input jumlah manual (live typing)
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('quantity')) {
        const row = e.target.closest('.produk-item');
        updateHargaDanSubtotal(row);
    }
    if (e.target.name === 'totalBayar') {
        updateKembalian();
    }
});
</script>