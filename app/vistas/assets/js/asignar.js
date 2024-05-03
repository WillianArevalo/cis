document.addEventListener("DOMContentLoaded", function () {
  // Buscamos todos los botones con la clase 'btn-move'
  const moveButtons = document.querySelectorAll(".btn-move");

  // Agregamos un manejador de eventos a cada botón
  moveButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Obtenemos el ID de la columna a la que moveremos el card
      const targetColumnId =
        this.closest(".columns").id === "column1" ? "column2" : "column1";
      const targetColumn = document.getElementById(targetColumnId);

      // Obtenemos el card actual y lo movemos a la columna de destino
      const card = this.closest(".card");
      targetColumn.appendChild(card);

      if (this.classList.contains("btn-edit")) {
        this.classList.remove("btn-edit");
        this.classList.add("btn-delete");
        this.textContent = "Eliminar";
      } else {
        this.classList.remove("btn-delete");
        this.classList.add("btn-edit");
        this.textContent = "Asignar";
      }
    });
  });

  $("#btn_asignar_becados").click(function () {
    const url = $(this).data("url");
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const cards = document.querySelectorAll("#column1 .card");
    const ids = [];
    cards.forEach((card) => {
      const cardId = card.getAttribute("data-id");
      ids.push(cardId);
    });
    if (ids) {
      var id_proyecto = $("#id_proyecto").val();
      console.log(ids);
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Los becados seleccionados serán asignados al proyecto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, asignar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: url,
            type: "POST",
            data: {
              id_proyecto: id_proyecto,
              ids: ids,
              _token: token,
            },
            success: function (respuesta) {
              var data = JSON.parse(respuesta);
              if (data.status == "success") {
                Swal.fire({
                  icon: data.status,
                  title: data.title,
                  text: data.message,
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
          });
        }
      });
    }
  });
});
