<?php


function formAgregarProyecto($comunidades)
{
    ob_start();
?>
    <form action="<?php echo url("/proyectos/agregar") ?>" method="POST" class="form" id="form-add-proyecto">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("folder") ?>
                    </span>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" placeholder="Nombre del proyecto">
                </div>
                <span class="message">Campo de nombre requerido.</span>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("location") ?>
                    </span>
                    <select name="comunidad" id="comunidad-proyecto">
                        <option value="">Elije una comunidad</option>
                        <?php
                        if ($comunidades != null) :
                            foreach ($comunidades as $comunidad) :
                        ?>
                                <option value="<?php echo $comunidad->id ?>"><?php echo $comunidad->nombre ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
}

function formEditarProyecto($proyecto, $comunidades)
{
    ob_start();
?>
    <form action="<?php echo url("/proyectos/actualizar") ?>" method="POST" class="form" id="form-edit-proyecto">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <input type="hidden" name="id" value="<?php echo $proyecto->id ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("folder") ?>
                    </span>
                    <input type="text" value="<?php echo $proyecto->nombre ?>" name="nombre_proyecto" id="nombre_proyecto" placeholder="Nombre del proyecto">
                </div>
                <span class="message">Campo de nombre requerido.</span>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("location") ?>
                    </span>
                    <select name="comunidad" id="comunidad-proyecto">
                        <option value="">Elije una comunidad</option>
                        <?php
                        if ($comunidades != null) :
                            foreach ($comunidades as $comunidad) :
                        ?>
                                <option value="<?php echo $comunidad->id ?>" <?php echo ($comunidad->id == $proyecto->id_comunidad) ? "selected" : "" ?>>
                                    <?php echo $comunidad->nombre ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
}

function formAgregarComunidad()
{
    ob_start();
?>
    <form action="<?php echo url("/comunidades/agregar") ?>" method="POST" class="form" id="form-add-comunidad">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("folder") ?>
                    </span>
                    <input type="text" name="nombre_comunidad" id="nombre_comunidad" placeholder="Nombre de la comunidad">
                </div>
            </div>
        </div>
    </form>

<?php
    $html = ob_get_clean();
    return $html;
}


function formEditComunidad($comunidad)
{
    ob_start();
?>
    <form action="<?php echo url("/comunidades/actualizar") ?>" method="POST" class="form" id="form-edit-comunidad">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <input type="hidden" name="id" value="<?php echo $comunidad->id ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("folder") ?>
                    </span>
                    <input type="text" name="nombre_comunidad" value="<?php echo $comunidad->nombre ?>" id="nombre_comunidad" placeholder="Nombre de la comunidad">
                </div>
            </div>
        </div>
    </form>

<?php
    $html = ob_get_clean();
    return $html;
}

function formAgregarUsuario()
{
    ob_start();
?>
    <form action="<?php echo url("/usuarios/agregar") ?>" method="POST" class="form" id="form-add-usuario">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("mail") ?>
                    </span>
                    <input type="text" name="email" id="email" placeholder="Email del usuario">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("user") ?>
                    </span>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("circle-password") ?>
                    </span>
                    <input type="text" name="password" id="password" placeholder="Contraseña">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("user-account") ?>
                    </span>
                    <select name="rol" id="rol">
                        <option value="">Elije un rol</option>
                        <option value="admin">Administrador</option>
                        <option value="becado">Becado</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
<?php
    $html = ob_get_clean();
    return $html;
}

function formEditarUsuario($usuario)
{
    ob_start();
?>
    <form action="<?php echo url("/usuarios/actualizar") ?>" method="POST" class="form" id="form-edit-usuario">
        <input type="hidden" name="_token" value="<?php echo obtenerToken(); ?>">
        <input type="hidden" name="id" value="<?php echo $usuario->id ?>">
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("mail") ?>
                    </span>
                    <input type="text" value="<?php echo $usuario->email ?>" name="email" id="email" placeholder="Email del usuario">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("user") ?>
                    </span>
                    <input type="text" value="<?php echo $usuario->usuario ?>" name="usuario" id="usuario" placeholder="Usuario">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-input">
                <div class="form-group-icon">
                    <span>
                        <?php echo icon("user-account") ?>
                    </span>
                    <select name="rol" id="rol">
                        <option value="">Elije un rol</option>
                        <option value="admin" <?php echo ($usuario->rol == "admin") ? "selected" : "" ?>>Administrador
                        </option>
                        <option value="becado" <?php echo ($usuario->rol == "becado") ? "selected" : "" ?>>Becado
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>
    <?php
    $html = ob_get_clean();
    return $html;
}

function imagesReport($reporte, $imagenes)
{
    ob_start();
    if ($imagenes) :
        foreach ($imagenes as $imagen) : ?>
            <div class="image">
                <img src="<?php echo asset("img/proyectos/" . $reporte->nombre_proyecto . "/" . $reporte->mes, $imagen->imagen) ?>" alt="<?php echo $imagen->imagen ?>">
                <button type="button" class="btn-delete delete-imagen" data-id-reporte="<?php echo $reporte->id ?>" data-id="<?php echo $imagen->id ?>" data-url="<?php echo url("/reportes/eliminar_imagen") ?>">
                    <?php echo icon("delete") ?>
                </button>
            </div>
        <?php endforeach;
        ?>
<?php
    endif;
    $html = ob_get_clean();
    return $html;
}
