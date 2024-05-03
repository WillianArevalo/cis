<main>
    <div class="container-login">
        <div class="login">
            <div class="login__header">
                <img src="<?php echo asset("img", "cis-logo.webp") ?>" alt="Logo CIS">
                <h2>Iniciar sesión</h2>
                <p>Centro de intercambio y Solidaridad</p>
            </div>
            <form action="<?php echo url("/login/validar") ?>" method="POST" id="form-login" class="login__form" novalidate>
                <input type="hidden" name="_token" value="<?php echo obtenerToken();  ?>">
                <div class="login__form-group">
                    <span>
                        <?php echo icon("mail") ?>
                    </span>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <span class="message" id="message-user">El campo del correo es requerido</span>
                <div class="login__form-group">
                    <span>
                        <?php echo icon("circle-password") ?>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <button type="button" id="toggle-password">
                        <span id="view">
                            <?php echo icon("view") ?>
                        </span>
                        <span id="hide">
                            <?php echo icon("view-off") ?>
                        </span>
                    </button>
                </div>
                <span class="message" id="message-password">El campo de usuario es requerido</span>
                <button type="submit" class="btn-primary">
                    <?php echo icon("login") ?>
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>
</main>