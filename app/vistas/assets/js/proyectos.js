document.addEventListener("DOMContentLoaded", function () {
  const token = document.querySelector('meta[name="csrf-token"]').content;
  $("#tabla-proyectos").on("click", ".delete-proyecto", function () {
    Swal.fire({
      title: "¿Estás seguro de eliminar este proyecto?",
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

  $("#button-add-proyecto").on("click", function () {
    const url = $(this).data("url");
    $.ajax({
      url: url,
      type: "POST",
      data: { _token: token },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == "success") {
          Swal.fire({
            title: "Agregar comunidad",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Agregar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const nombre = document.getElementById("nombre_proyecto");
              const comunidad = document.getElementById("comunidad-proyecto");
              if (nombre.value == "" || comunidad.value == "") {
                nombre.classList.add("is-invalid");
                comunidad.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              } else {
                return {
                  nombre: nombre,
                  comunidad: comunidad,
                };
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              console.log($("#form-add-comunidad").attr("action"));

              $.ajax({
                url: $("#form-add-proyecto").attr("action"),
                type: $("#form-add-proyecto").attr("method"),
                data: $("#form-add-proyecto").serialize(),
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

  $("#tabla-proyectos").on("click", ".edit-proyecto", function () {
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
            title: "Editar proyecto",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Editar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const nombre = document.getElementById("nombre_proyecto");
              const comunidad = document.getElementById("comunidad-proyecto");
              if (nombre.value == "" || comunidad.value == "") {
                nombre.classList.add("is-invalid");
                comunidad.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              } else {
                return {
                  nombre: nombre,
                  comunidad: comunidad,
                };
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $("#form-edit-proyecto").attr("action"),
                type: $("#form-edit-proyecto").attr("method"),
                data: $("#form-edit-proyecto").serialize(),
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
