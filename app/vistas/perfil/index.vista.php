<main class="main-<?php echo (isset($usuario)) ? $usuario->rol : "" ?>">
    <div class="perfil">
        <div class="perfil-image">
            <img src="<?php echo (isset($becado) && isset($becado->foto)) ? asset("img/becados", $becado->foto) : asset("img", "not-found-image.png") ?>"
                alt="Imagen <?php echo (isset($becado) && isset($becado->nombre)) ? $becado->nombre : $usuario->usuario ?>">
            <h6>
                <?php echo icon("mail") ?>
                <?php echo $usuario->email ?>
            </h6>
        </div>
        <div class="perfil-info">
            <div class="perfil-info-data">
                <h1><?php echo (isset($becado) && isset($becado->nombre)) ? $becado->nombre : "Usuario" ?></h1>
                <p><?php echo $usuario->usuario ?></p>
                <p><?php echo (isset($comunidad) && isset($comunidad->nombre)) ? $comunidad->nombre : "Sin comunidad asignada" ?>
                </p>
                <p><?php echo (isset($proyecto) && isset($proyecto->nombre)) ? $proyecto->nombre : "Sin proyecto asignado" ?>
                </p>
            </div>
            <div class="perfil-info-pass">
                <div class="form-usuario">
                    <h5>Cambiar contraseña</h5>
                    <form action="<?php echo url("/perfil/actualizar") ?>" method="POST" id="form-perfil">
                        <div class="row">
                            <div class="form-input">
                                <div class="form-group-icon">
                                    <span>
                                        <?php echo icon("circle-password") ?>
                                    </span>
                                    <input type="password" name="nueva_password" id="newPass"
                                        placeholder="Nueva contraseña">
                                </div>
                                <span class="message">Campo de la nueva contraseña requerida.</span>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="form-input">
                                <div class="form-group-icon">
                                    <span>
                                        <?php echo icon("circle-password") ?>
                                    </span>
                                    <input type="password" name="confirm_password" id="confirmPass"
                                        placeholder="Confirmar contraseña">
                                </div>
                                <span class="message">Campo de confirmación de la contraseña requerida.</span>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <button type="submit" class="btn-info">
                                Actualizar contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>