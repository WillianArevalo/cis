<?php $becado = (obtenerSesión("becado") ? obtenerSesión("becado") : ""); ?>
<header class="header-becado">
    <nav class="navbar-becado">
        <div class="navbar-becado__logo">
            <img src="<?php echo asset("img", "cis-logo.webp") ?>" alt="Logo">
        </div>
        <ul class="navbar-becado__links">
            <li>
                <a href="<?php echo url("/inicio") ?>">
                    <?php echo icon("home") ?>
                    Inicio
                </a>
            </li>
            <li>
                <a href="<?php echo url("/reportes") ?>">
                    <?php echo icon("report") ?>
                    Reportes
                </a>
            </li>
        </ul>
        <div class="top-bar__user-toggle-theme">
            <button id="lightButton" class="button-theme">
                <span id="icon-sun">
                    <?php echo icon("sun") ?>
                </span>
            </button>
            <button id="darkButton" class="button-theme">
                <span id="icon-moon">
                    <?php echo icon("moon") ?>
                </span>
            </button>
        </div>
        <div class="navbar-becado__user">
            <div class="user-img">
                <a href="<?php echo url("/perfil") ?>">
                    <img src="<?php echo (isset($becado) && isset($becado->foto)) ? asset("img/becados", $becado->foto) : asset("img", "not-found-image.png") ?>" alt="Imagen de perfil del usuario">
                </a>
            </div>
        </div>
        <ul class="navbar-becado__logout">
            <li class="link-logout" data-url="<?php echo url("/login/logout") ?>">
                <a href="#">
                    <?php echo icon("logout") ?>
                </a>
            </li>
        </ul>
        <button class="btn-hamburger-becado">
            <span id="icon-menu">
                <?php echo icon("menu") ?>
            </span>
            <span id="icon-cancel">
                <?php echo icon("cancel") ?>
            </span>
        </button>
    </nav>
    <nav class="navbar-becado-mobile">
        <div class="navbar-becado__user-mobile">
            <div class="user-img">
                <a href="<?php echo url("/perfil") ?>">
                    <img src="<?php echo (isset($becado) && isset($becado->foto)) ? asset("img/becados", $becado->foto) : asset("img", "not-found-image.png") ?>" alt="Imagen de perfil del usuario">
                </a>
            </div>
        </div>
        <ul class="navbar-becado__links-mobile">
            <li>
                <a href="<?php echo url("/inicio") ?>">
                    <?php echo icon("home") ?>
                    Inicio
                </a>
            </li>
            <li>
                <a href="<?php echo url("/reportes") ?>">
                    <?php echo icon("report") ?>
                    Reportes
                </a>
            </li>
            <li class="link-logout" data-url="<?php echo url("/login/logout") ?>">
                <a href="#">
                    <?php echo icon("logout") ?>
                    Cerrar sesión
                </a>
            </li>
        </ul>
    </nav>
</header>