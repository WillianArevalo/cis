document.addEventListener("DOMContentLoaded", function () {
  const btnHambBecado = document.querySelector(".btn-hamburger-becado");
  const menuBecado = document.querySelector(".navbar-becado-mobile");

  if (btnHambBecado !== null && menuBecado !== null) {
    btnHambBecado.addEventListener("click", function () {
      menuBecado.classList.toggle("active");
      btnHambBecado.classList.toggle("active");
    });
  }

  const btnHambAdmin = document.querySelector(".btn-hamburger");
  const menuAdmin = document.querySelector(".navbar-admin-mobile");

  if (btnHambAdmin !== null && menuAdmin !== null) {
    btnHambAdmin.addEventListener("click", function () {
      menuAdmin.classList.toggle("active");
      btnHambAdmin.classList.toggle("active");
    });
  }

  const perfilImage = document.getElementById("image-perfil");
  const dropdownMenu = document.querySelector(".top-bar__user-dropdown");

  if (perfilImage) {
    perfilImage.addEventListener("click", function () {
      dropdownMenu.classList.toggle("show");
    });
  }

  document.addEventListener("click", function (event) {
    const element = event.target;
    if (
      !element.classList.contains("top-bar__user-dropdown") &&
      element.id !== "image-perfil"
    ) {
      if (dropdownMenu) {
        dropdownMenu.classList.remove("show");
      }
    }
  });
});
