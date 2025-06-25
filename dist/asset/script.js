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

// Delete Data
$(document).ready(function () {
  const table = $("#tableProduct").DataTable();

  $("#tableProduct").on("click", "a.hapus", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
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
