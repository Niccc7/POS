// Create Data
$(document).ready(function () {
  const table = $("#tableProduct").DataTable();

  $("#formTambah").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "produk/product-create.php",
      method: "POST",
      data: $(this).serialize() + "&tambah=true",
      success: function (response) {
        const res = JSON.parse(response);

        Swal.fire({
          icon: res.status === "success" ? "success" : "error",
          title: res.message,
          showConfirmButton: false,
          timer: 1500,
        });

        if (res.status === "success") {
          $("#addData").modal("hide");
          $("#formTambah")[0].reset();

          setTimeout(() => {
            location.reload();
          }, 1800);
        } else {
          setTimeout(() => {
            $("#alert-container").html("");
          }, 1800);
        }
      },
    });
  });
});

// Edit Data
$(document).on("click", ".btn-edit", function () {
  let id = $(this).data("id");
  let kode = $(this).data("kodeProduk");
  let name = $(this).data("namaProduk");
  let harga = $(this).data("harga");

  $("#edit-id").val(id);
  $("#edit-kode").val(kode);
  $("#edit-nama").val(name);
  $("#edit-harga").val(harga);
});

$("#formEdit").on("submit", function (e) {
  e.preventDefault();
  console.log("Data dikirim:", $(this).serialize());

  $.ajax({
    url: "produk/product-edit.php",
    method: "POST",
    data: $(this).serialize() + "&edit=true",
    success: function (response) {
      const res = JSON.parse(response);

      Swal.fire({
        icon: res.status === "success" ? "success" : "error",
        title: res.message,
        showConfirmButton: false,
        timer: 1500,
      });

      if (res.status === "success") {
        $("#editData").modal("hide");
        setTimeout(() => {
          location.reload();
        }, 1800);
      } else {
        setTimeout(() => {
          $("#alert-container").html("");
        }, 1800);
      }
    },
  });
});

// Delete Data produk
$(document).ready(function () {
  const table = $("#tableProduct").DataTable();

  $("#tableProduct").on("click", "a.hapus", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    Swal.fire({
      title: "Anda Yakin ?",
      text: "Setelah Menghapus Anda Tidak Dapat Memulihkannya kembali!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#403E92",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          method: "GET",
          success: function (response) {
            const res = JSON.parse(response);

            Swal.fire({
              icon: res.status === "success" ? "success" : "error",
              title: res.message,
              showConfirmButton: false,
              timer: 1500,
            });

            if (res.status === "success") {
              setTimeout(() => {
                location.reload();
              }, 1800);
            }
          },
        });
      }
    });
  });
});

$(document).on("click", ".btn-edit-stok", function () {
  let id = $(this).data("id");
  let kode = $(this).data("kode-produk"); 
  let nama = $(this).data("nama-produk");
  let stok = $(this).data("stok");

  $("#edit-id").val(id);
  $("#edit-kode").val(kode);
  $("#edit-nama").val(nama);
  $("#edit-stok").val(stok);
});

$("#formEditStok").on("submit", function (e) {
  e.preventDefault();
  console.log("Data dikirim:", $(this).serialize());

  $.ajax({
    url: "stok/stock-edit.php",
    method: "POST",
    data: $(this).serialize() + "&edit=true",
    success: function (response) {
      const res = JSON.parse(response);

      Swal.fire({
        icon: res.status === "success" ? "success" : "error",
        title: res.message,
        showConfirmButton: false,
        timer: 1500,
      });

      if (res.status === "success") {
        $("#editData").modal("hide");
        setTimeout(() => {
          location.reload();
        }, 1800);
      } else {
        setTimeout(() => {
          $("#alert-container").html("");
        }, 1800);
      }
    },
  });
});

$("#formTransaksi").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        url: "transaksi/transaksi-store.php",
        method: "POST",
        data: $(this).serialize() + "&tambah=true",
        success: function (response) {
            try {
                const res = JSON.parse(response);

                Swal.fire({
                    icon: res.status === "success" ? "success" : "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });

                if (res.status === "success") {
                    $("#formTransaksi")[0].reset();

                    setTimeout(() => {
                        location.href = "transaksi.php";
                    }, 1800);
                }
            } catch (err) {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi kesalahan!",
                    text: "Response tidak valid dari server.",
                });
                console.error("Invalid JSON:", response);
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Gagal mengirim data",
                text: error,
            });
        }
    });
});

// Delete Data transaksi
$(document).ready(function () {
  const table = $("#tableTr").DataTable();

  $("#tableTr").on("click", "a.hapus", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    Swal.fire({
      title: "Anda Yakin ?",
      text: "Setelah Menghapus Anda Tidak Dapat Memulihkannya kembali!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#403E92",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          method: "GET",
          success: function (response) {
            const res = JSON.parse(response);

            Swal.fire({
              icon: res.status === "success" ? "success" : "error",
              title: res.message,
              showConfirmButton: false,
              timer: 1500,
            });

            if (res.status === "success") {
              setTimeout(() => {
                location.reload();
              }, 1800);
            }
          },
        });
      }
    });
  });
});