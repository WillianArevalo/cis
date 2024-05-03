<?php $user = obtenerSesión("usuario") ?>
<header class="header-admin">
    <nav class="navbar-admin">
        <div class="navbar-admin__logo">
            <img src="<?php echo asset("img", "cis-logo.webp") ?>" alt="Logo">
            <h2>ADMIN</h2>
        </div>
        <ul class="navbar-admin__links">
            <li>
                <a href="<?php echo url("/dashboard") ?>" class="<?php echo currentPage("dashboard") ?>">
                    <?php echo icon("home") ?>
                    <p>Inicio</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/becados") ?>" class="<?php echo currentPage("becados") ?>">
                    <?php echo icon("student") ?>
                    <p>Becados</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/proyectos") ?>" class="<?php echo currentPage("proyectos") ?>">
                    <?php echo icon("folder") ?>
                    <p>Proyectos</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/comunidades") ?>" class="<?php echo currentPage("comunidades") ?>">
                    <?php echo icon("community") ?>
                    <p>Comunidades</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/usuarios") ?>" class="<?php echo currentPage("usuarios") ?>">
                    <?php echo icon("user-group") ?>
                    <p>Usuarios</p>
                </a>
            </li>
            <li class="link-logout" id="logout" data-url="<?php echo url("/login/logout") ?>">
                <a href="#">
                    <?php echo icon("logout") ?>
                    <p>Cerrar sesión</p>
                </a>
            </li>
        </ul>
    </nav>
    <div class="top-bar">
        <div class="top-bar__user">
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
            <img src="<?php echo asset("img", "gatico.jpeg") ?>" alt="Imagen de perfil del usuario" id="image-perfil">
            <div class="top-bar__user-dropdown">
                <ul class="top-bar__user-dropdown-links">
                    <li>
                        <a href="<?php echo url("/perfil") ?>">
                            <?php echo icon("user-circle") ?>
                            Perfil
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <?php echo icon("settings") ?>
                            Configuración
                        </a>
                    </li>
                </ul>
            </div>
            <button class="btn-hamburger">
                <span id="icon-menu">
                    <?php echo icon("menu") ?>
                </span>
                <span id="icon-cancel">
                    <?php echo icon("cancel") ?>
                </span>
            </button>
        </div>
    </div>

    <nav class="navbar-admin-mobile">
        <ul class="navbar-admin__links-mobile">
            <li>
                <a href="<?php echo url("/dashboard") ?>" class="<?php echo currentPage("dashboard") ?>">
                    <?php echo icon("home") ?>
                    <p>Inicio</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/becados") ?>" class="<?php echo currentPage("becados") ?>">
                    <?php echo icon("student") ?>
                    <p>Becados</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/proyectos") ?>" class="<?php echo currentPage("proyectos") ?>">
                    <?php echo icon("folder") ?>
                    <p>Proyectos</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/comunidades") ?>" class="<?php echo currentPage("comunidades") ?>">
                    <?php echo icon("community") ?>
                    <p>Comunidades</p>
                </a>
            </li>
            <li>
                <a href="<?php echo url("/usuarios") ?>" class="<?php echo currentPage("comunidades") ?>">
                    <?php echo icon("user-group") ?>
                    <p>Usuarios</p>
                </a>
            </li>
            <li class="link-logout" id="logout" data-url="<?php echo url("/login/logout") ?>">
                <a href="#">
                    <?php echo icon("logout") ?>
                    <p>Cerrar sesión</p>
                </a>
            </li>
        </ul>
    </nav>
</header>