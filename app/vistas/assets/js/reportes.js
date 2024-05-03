document.addEventListener("DOMContentLoaded", function () {
  const btnDisabled = document.querySelectorAll(".btn-secondary.disabled");
  if (btnDisabled.length > 0) {
    btnDisabled.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        Swal.fire({
          title: "¡No puedes realizar esta acción!",
          text: "No tienes permisos para realizar esta acción.",
          icon: "warning",
          confirmButtonText: "¡Entendido!",
        });
      });
    });
  }

  FilePond.registerPlugin(FilePondPluginImagePreview);
  FilePond.registerPlugin(FilePondPluginImageValidateSize);
  FilePond.registerPlugin(FilePondPluginFileValidateSize);
  const imageReport = document.querySelector('input[id="image-report"]');
  const pond = FilePond.create(imageReport, {
    labelIdle:
      "Arrastra y suelta tus archivos o <span class='filepond--label-action'> Examinar </span>",
    imagePreviewHeight: 250,
    imagePreviewWidth: 250,
    allowImagePreview: true,
    allowMultiple: true,
    maxFiles: 10,
    minFiles: 5,
    maxFileSize: "5MB",
    minFileSize: "1KB",
    labelMaxFileSizeExceeded: "El archivo es demasiado grande",
    labelMaxFileSize: "El tamaño máximo del archivo es {filesize}",
  });

  function validarCampo(input, minLength) {
    var valor = input.val().trim();
    const parent = input.parent();
    const message = parent.next(".message");
    if (valor === "") {
      input.addClass("is-invalid");
      return false;
    } else {
      var caracteresRestantes = minLength - valor.length;
      if (valor.length < minLength) {
        input.addClass("is-invalid");
        message
          .css("display", "block")
          .text("Faltan " + caracteresRestantes + " caracteres.");
        return false;
      } else {
        input.removeClass("is-invalid");
        message.css("display", "none");
        return true;
      }
    }
  }

  $("#tema, #descripcion, #obstaculos").on("input", function () {
    var input = $(this);
    var minLength = parseInt(input.attr("data-min-lenght"));
    validarCampo(input, minLength);
  });

  $("#participantes").on("input", function () {
    if ($(this).val().trim() === "") {
      $(this).addClass("is-invalid");
      const parent = $(this).parent();
      const message = parent.next(".message");
      message
        .css("display", "block")
        .text("Los participantes son obligatorios");
    } else {
      $(this).removeClass("is-invalid");
      const parent = $(this).parent();
      const message = parent.next(".message");
      message.css("display", "none");
    }
  });

  const formReport = document.getElementById("form-report");
  if (formReport) {
    formReport.addEventListener("submit", (e) => {
      e.preventDefault();
      const tema = $("#tema");
      const participantes = $("#participantes");
      const descripcion = $("#descripcion");
      const obstaculos = $("#obstaculos");
      const accion = formReport.getAttribute("data-form");

      if (tema.val().trim() === "") {
        tema.addClass("is-invalid");
        const parent = tema.parent();
        const message = parent.next(".message");
        message.css("display", "block").text("El tema es obligatorio");
      }

      if (participantes.val().trim() === "") {
        participantes.addClass("is-invalid");
        const parent = participantes.parent();
        const message = parent.next(".message");
        message
          .css("display", "block")
          .text("Los participantes son obligatorios");
      }

      if (descripcion.val().trim() === "") {
        descripcion.addClass("is-invalid");
        const parent = descripcion.parent();
        const message = parent.next(".message");
        message.css("display", "block").text("La descripción es obligatoria");
      }

      if (obstaculos.val().trim() === "") {
        obstaculos.addClass("is-invalid");
        const parent = obstaculos.parent();
        const message = parent.next(".message");
        message.css("display", "block").text("Los obstáculos son obligatorios");
      }

      var isValidTema = validarCampo(
        tema,
        parseInt(tema.attr("data-min-lenght"))
      );
      var isValidParticipantes = validarCampo(
        participantes,
        parseInt(participantes.attr("data-min-lenght"))
      );
      var isValidDescripcion = validarCampo(
        descripcion,
        parseInt(descripcion.attr("data-min-lenght"))
      );
      var isValidObstaculos = validarCampo(
        obstaculos,
        parseInt(obstaculos.attr("data-min-lenght"))
      );

      if (
        tema.val().trim() != "" &&
        participantes.val().trim() != "" &&
        descripcion.val().trim() != "" &&
        obstaculos.val().trim() != "" &&
        isValidTema &&
        isValidParticipantes &&
        isValidDescripcion &&
        isValidObstaculos
      ) {
        let images = pond.getFiles();
        const formData = new FormData($("#form-report")[0]);
        if (accion == "enviar") {
          if (images && images.length >= 5) {
            for (let image of images) {
              formData.append("imagenes_reporte[]", image.file);
            }
          } else {
            Swal.fire({
              title: "¡Error!",
              text: "Por favor, selecciona al menos 5 imágenes.",
              icon: "error",
            });
            return;
          }
        } else if (accion == "editar") {
          if (images && images.length > 0) {
            for (let image of images) {
              formData.append("imagenes_reporte[]", image.file);
            }
          } else {
            formData.append("imagenes_reporte[]", null);
          }
        }

        const url = formReport.action;
        const method = formReport.method;
        $.ajax({
          url: url,
          type: method,
          data: formData,
          processData: false,
          contentType: false,
          beforeSend: function () {
            $("#overlay").css("display", "block");
            $("#load").addClass("loading");
          },
          success: function (response) {
            $("#overlay").css("display", "none");
            $("#load").removeClass("loading");
            var data = JSON.parse(response);
            if (data.status == "success") {
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
                title: data.title,
                text: data.message,
                icon: data.status,
              });
            }
          },
        });
      }
    });
  }

  $(".delete-reporte").on("click", function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    Swal.fire({
      title: "¿Estás seguro de eliminar este reporte?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "¡Sí, eliminar!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var data = {
          id: id,
          _token: token,
        };
        $.ajax({
          url: url,
          type: "POST",
          data: data,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status == "success") {
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
                title: data.title,
                text: data.message,
                icon: data.status,
              });
            }
          },
        });
      }
    });
  });

  $("#images-reportes").on("click", ".delete-imagen", function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    Swal.fire({
      title: "¿Estás seguro de eliminar esta imágen?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "¡Sí, eliminar!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var idReporte = $(this).data("id-reporte");
        var data = {
          id: id,
          _token: token,
          id_reporte: idReporte,
        };
        $.ajax({
          url: url,
          type: "POST",
          data: data,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status == "success") {
              Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.status,
                showCancelButton: false,
              });
              $("#images-reportes").html(data.html);
            } else {
              Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.status,
              });
            }
          },
        });
      }
    });
  });
});
