document.addEventListener("DOMContentLoaded", function () {
  const formLogin = document.getElementById("form-login");
  const togglePassword = document.getElementById("toggle-password");

  if (formLogin) {
    formLogin.addEventListener("submit", function (event) {
      event.preventDefault();
      const email = document.getElementById("email");
      const password = document.getElementById("password");

      if (email.value === "") {
        email.classList.add("is-invalid");
        document.getElementById("message-user").style.display = "block";
      } else {
        email.classList.remove("is-invalid");
        document.getElementById("message-user").style.display = "none";
      }

      if (password.value === "") {
        password.classList.add("is-invalid");
        togglePassword.classList.add("is-invalid");
        document.getElementById("message-password").style.display = "block";
      } else {
        password.classList.remove("is-invalid");
        togglePassword.classList.remove("is-invalid");
        document.getElementById("message-password").style.display = "none";
      }

      if (email.value !== "" && password.value !== "") {
        console.log(this.action);
        $.ajax({
          url: this.action,
          type: this.method,
          data: $(this).serialize(),
          success: function (response) {
            var data = JSON.parse(response);
            console.log(data);
            if (data.status === "success") {
              Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.status,
                showCancelButton: false,
                textConfirmButton: "Aceptar",
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
                showCancelButton: false,
                textConfirmButton: "Aceptar",
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

  const logout = document.querySelectorAll(".link-logout");
  if (logout) {
    logout.forEach((btn) => {
      btn.addEventListener("click", function () {
        const url = $(this).attr("data-url");
        Swal.fire({
          title: "Cerrar sesión",
          text: "¿Estás seguro de cerrar sesión?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Cerrar sesión",
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.value) {
            window.location.href = url;
          }
        });
      });
    });
  }

  if (togglePassword) {
    togglePassword.addEventListener("click", function () {
      togglePaswordVisibility();
    });
  }

  function togglePaswordVisibility() {
    const password = document.getElementById("password");
    const view = document.getElementById("view");
    const hide = document.getElementById("hide");

    if (password.type == "password") {
      password.type = "text";
      view.style.display = "flex";
      hide.style.display = "none";
    } else {
      password.type = "password";
      view.style.display = "none";
      hide.style.display = "flex";
    }
  }
});
