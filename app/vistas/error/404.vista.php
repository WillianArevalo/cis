<?php $usuario = obtenerSesión("usuario") ?>
<main class="main-admin error">
    <div class="container-error">
        <div class="error">
            <h1>404</h1>
            <h2>Página no encontrada</h2>
            <p>La página que buscas no existe o ha sido eliminada.</p>
            <a href="<?php echo ($usuario) ? (($usuario->rol == "admin") ? url("/dashboard") : url("/inicio")) : url("/") ?>" class="btn-primary">Volver al inicio</a>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php
            if ($status) :
            ?>
                Swal.fire({
                    title: "<?php echo $title ?>",
                    text: "<?php echo $message ?>",
                    icon: "<?php echo $status ?>",
                    confirmButtonText: "Aceptar",
                    showCancelButton: false,
                    showCloseButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo $redirect ?>";
                    }
                })
            <?php
            endif;
            ?>
        })
    </script>
</main>