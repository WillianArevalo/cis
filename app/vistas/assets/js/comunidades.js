document.addEventListener("DOMContentLoaded", function () {
  const token = document.querySelector('meta[name="csrf-token"]').content;
  $("#tabla-comunidades").on("click", ".delete-comunidad", function () {
    Swal.fire({
      title: "¿Estás seguro de eliminar esta comunidad?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "¡Sí, eliminar!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        $.ajax({
          url: url,
          type: "POST",
          data: { _token: token, id: id },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === "success") {
              Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.status,
                showCancelButton: false,
              }).then((result) => {
                if (result.value) {
                  window.location.href = data.redirect;
                }
              });
            } else {
              Swal.fire({
                icon: data.status,
                title: data.title,
                text: data.message,
              }).then((result) => {
                if (result.value) {
                  window.location.href = data.redirect;
                }
              });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
      }
    });
  });

  $("#button-add-comunidad").on("click", function () {
    const url = $(this).data("url");
    $.ajax({
      url: url,
      type: "POST",
      data: { _token: token },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == "success") {
          Swal.fire({
            title: "Agregar Proyecto",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Agregar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const nombre = document.getElementById("nombre_comunidad");
              if (nombre.value == "") {
                nombre.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $("#form-add-comunidad").attr("action"),
                type: $("#form-add-comunidad").attr("method"),
                data: $("#form-add-comunidad").serialize(),
                success: function (response) {
                  var data = JSON.parse(response);
                  if (data.status === "success") {
                    Swal.fire({
                      title: data.title,
                      text: data.message,
                      icon: data.status,
                      showCancelButton: false,
                    }).then((result) => {
                      if (result.value) {
                        window.location.reload();
                      }
                    });
                  } else {
                    Swal.fire({
                      icon: data.status,
                      title: data.title,
                      text: data.message,
                    });
                  }
                },
              });
            }
          });
        }
      },
    });
  });

  $("#tabla-comunidades").on("click", ".edit-comunidad", function () {
    const url = $(this).data("url");
    const id = $(this).data("id");
    $.ajax({
      url: url,
      type: "POST",
      data: { _token: token, id: id },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == "success") {
          Swal.fire({
            title: "Editar comunidad",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Editar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const nombre = document.getElementById("nombre_comunidad");
              if (nombre.value == "") {
                nombre.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $("#form-edit-comunidad").attr("action"),
                type: $("#form-edit-comunidad").attr("method"),
                data: $("#form-edit-comunidad").serialize(),
                success: function (response) {
                  var data = JSON.parse(response);
                  if (data.status === "success") {
                    Swal.fire({
                      title: data.title,
                      text: data.message,
                      icon: data.status,
                      showCancelButton: false,
                    }).then((result) => {
                      if (result.value) {
                        window.location.reload();
                      }
                    });
                  } else {
                    Swal.fire({
                      icon: data.status,
                      title: data.title,
                      text: data.message,
                    });
                  }
                },
              });
            }
          });
        }
      },
    });
  });
});
