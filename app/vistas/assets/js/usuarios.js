document.addEventListener("DOMContentLoaded", function () {
  const token = document.querySelector('meta[name="csrf-token"]').content;
  $("#tabla-usuarios").on("click", ".delete-usuario", function () {
    Swal.fire({
      title: "¿Estás seguro de eliminar este usuario?",
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
                  location.reload();
                }
              });
            } else {
              Swal.fire({
                icon: data.status,
                title: data.title,
                text: data.message,
              }).then((result) => {
                if (result.value) {
                  location.reload();
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

  $("#button-add-usuario").on("click", function () {
    const url = $(this).data("url");
    $.ajax({
      url: url,
      type: "POST",
      data: { _token: token },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == "success") {
          Swal.fire({
            title: "Agregar usuario",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Agregar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const email = document.getElementById("email");
              const usuario = document.getElementById("usuario");
              const password = document.getElementById("password");
              const rol = document.getElementById("rol");
              if (
                email.value == "" ||
                usuario.value == "" ||
                password.value == "" ||
                rol.value == ""
              ) {
                email.classList.add("is-invalid");
                usuario.classList.add("is-invalid");
                password.classList.add("is-invalid");
                rol.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $("#form-add-usuario").attr("action"),
                type: $("#form-add-usuario").attr("method"),
                data: $("#form-add-usuario").serialize(),
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

  $("#tabla-usuarios").on("click", ".edit-usuario", function () {
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
            title: "Editar usuario",
            html: data.html,
            showCancelButton: true,
            confirmButtonText: "Editar",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
              const email = document.getElementById("email");
              const usuario = document.getElementById("usuario");
              const rol = document.getElementById("rol");
              if (email.value == "" || usuario.value == "" || rol.value == "") {
                email.classList.add("is-invalid");
                usuario.classList.add("is-invalid");
                rol.classList.add("is-invalid");
                Swal.showValidationMessage("Completa todos los campos.");
              }
            },
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $("#form-edit-usuario").attr("action"),
                type: $("#form-edit-usuario").attr("method"),
                data: $("#form-edit-usuario").serialize(),
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
