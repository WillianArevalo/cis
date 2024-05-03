document.addEventListener("DOMContentLoaded", function () {
  const imagenBecado = document.getElementById("imagen_becado");
  if (imagenBecado) {
    imagenBecado.addEventListener("change", function () {
      var archivo = this.files[0];
      if (archivo) {
        var lector = new FileReader(); // Crear un objeto FileReader
        lector.onload = function (e) {
          var vistaPrevia = document.getElementById("preview-image");
          vistaPrevia.src = e.target.result; // Establecer la fuente de la imagen seleccionada
        };
        lector.readAsDataURL(archivo); // Leer el archivo como una URL de datos
      }
    });
  }

  const formAdd = document.getElementById("form-add-becado");
  if (formAdd) {
    formAdd.addEventListener("submit", function (e) {
      e.preventDefault();

      var inputs = formAdd.querySelectorAll("input ,select");
      var formValidate = true;
      inputs.forEach((input) => {
        if (input.value === "") {
          input.classList.add("is-invalid");
          var parent = input.parentElement;
          var message = parent.nextElementSibling;

          if (message) {
            message.style.display = "block";
            formValidate = false;
          }
        } else {
          input.classList.remove("is-invalid");
        }

        if (input.id === "imagen_becado" && input.value === "") {
          $("#container-preview-image").addClass("is-invalid");
        } else {
          $("#container-preview-image").removeClass("is-invalid");
        }
      });

      if (formValidate) {
        var formData = new FormData($("#form-add-becado")[0]);
        $.ajax({
          url: this.action,
          type: this.method,
          data: formData,
          contentType: false,
          processData: false,
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
              });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
      }
    });
  }

  $("#tabla-becados").on("click", ".delete-becado", function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    Swal.fire({
      title: "¿Estás seguro de eliminar este becado?",
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
            console.log(data);
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

  const formEdit = document.getElementById("form-edit-becado");
  if (formEdit) {
    formEdit.addEventListener("submit", function (e) {
      e.preventDefault();

      var inputs = formEdit.querySelectorAll("input ,select");
      var formValidate = true;
      inputs.forEach((input) => {
        if (input.value === "" && input.id !== "imagen_becado") {
          input.classList.add("is-invalid");
          var parent = input.parentElement;
          var message = parent.nextElementSibling;

          if (message) {
            message.style.display = "block";
            formValidate = false;
          }
        } else {
          input.classList.remove("is-invalid");
        }
      });

      if (formValidate) {
        var formData = new FormData($("#form-edit-becado")[0]);
        $.ajax({
          url: this.action,
          type: this.method,
          data: formData,
          contentType: false,
          processData: false,
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
              });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
      }
    });
  }
});
