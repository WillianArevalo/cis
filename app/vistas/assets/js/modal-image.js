document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("main-image")) {
      const mainImage = event.target;
      const modal = document.getElementById("modal-image");
      const imageModal = document.getElementById("image-modal");
      const body = document.getElementById("body");

      modal.style.display = "block";
      body.classList.add("active");
      imageModal.src = mainImage.src;
    }
  });

  var mainImagen = document.querySelectorAll(".main-image");
  var modal = document.getElementById("modal-image");
  var imagenModal = document.getElementById("image-modal");
  const body = document.getElementById("body");

  if (mainImagen) {
    mainImagen.forEach((imagen) => {
      imagen.addEventListener("click", function () {
        modal.style.display = "block";
        body.classList.add("active");
        imagenModal.src = this.src;
      });
    });
  }

  var close = document.getElementById("close-modal");
  if (close) {
    close.addEventListener("click", function () {
      body.classList.remove("active");
      modal.style.display = "none";
    });
  }
});
